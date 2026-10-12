import pool from "@/lib/db";
import { RowDataPacket } from "mysql2";
import ReviewClient from "./ReviewClient";

export const metadata = {
  title: "Customer Reviews & Experiences | Pawar Handloom",
  description:
    "Authentic reviews and ratings from our customers on Maheshwari and Chanderi handloom sarees, suits, and store experiences.",
};

// Force dynamic so newly posted reviews appear immediately
export const dynamic = "force-dynamic";
export const revalidate = 0;

export default async function ReviewPage() {
  let initialReviews: any[] = [];
  let stats = {
    totalReviews: 0,
    averageRating: 0,
    ratingCounts: { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 } as Record<number, number>,
  };
  let productsList: { id: number; name: string }[] = [];

  try {
    // 1. Fetch review statistics (matching CodeIgniter getReviewStats)
    const [statRows] = await pool.query<RowDataPacket[]>(`
      SELECT rating, COUNT(*) as count
      FROM tbl_review
      WHERE status = 1 AND is_deleted = 1
      GROUP BY rating
    `);

    let totalReviews = 0;
    let totalRating = 0;
    const ratingCounts: Record<number, number> = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 };

    statRows.forEach((row) => {
      const r = Number(row.rating);
      const c = Number(row.count);
      if (r >= 1 && r <= 5) {
        ratingCounts[r] = c;
      }
      totalReviews += c;
      totalRating += r * c;
    });

    const averageRating = totalReviews > 0 ? Number((totalRating / totalReviews).toFixed(1)) : 0;

    stats = {
      totalReviews,
      averageRating,
      ratingCounts,
    };

    // 2. Fetch all reviews with grouped images & product details (matching CodeIgniter getReviewsWithImages)
    const [reviewRows] = await pool.query<RowDataPacket[]>(`
      SELECT 
        r.id,
        r.product_id,
        p.product_name,
        r.name,
        r.email,
        r.review_title,
        r.rating,
        r.review_text,
        r.YouTube_url,
        r.likes,
        r.review_type,
        r.created_at,
        GROUP_CONCAT(ri.review_image) as review_images
      FROM tbl_review r
      LEFT JOIN tbl_product p ON p.id = r.product_id
      LEFT JOIN tbl_review_image ri ON ri.review_id = r.id AND ri.status = 1 AND ri.is_deleted = 1
      WHERE r.status = 1 AND r.is_deleted = 1
      GROUP BY r.id
      ORDER BY r.created_at DESC;
    `);

    initialReviews = reviewRows.map((row) => {
      const rawImages = row.review_images ? String(row.review_images).split(",") : [];
      const images = rawImages
        .map((img) => img.trim())
        .filter(Boolean)
        .map((img) =>
          img.startsWith("http")
            ? img
            : `http://localhost:8080/uploads/review_images/${img}`
        );

      return {
        id: Number(row.id),
        product_id: Number(row.product_id) || 0,
        product_name: row.product_name || (row.review_type === 1 ? "Product" : undefined),
        name: row.name || "Customer",
        email: row.email || "",
        rating: Math.max(1, Math.min(5, Number(row.rating) || 5)), // Normalise to 1..5 for UI display
        review_title: row.review_title || "Customer Review",
        review_text: row.review_text || "",
        review_type: Number(row.review_type) === 1 ? 1 : 2,
        likes: Number(row.likes) || 0,
        created_at: row.created_at
          ? new Date(row.created_at).toISOString().split("T")[0]
          : new Date().toISOString().split("T")[0],
        location: row.review_type === 1 ? "Verified Buyer" : "Store Patron",
        verified: true,
        review_images: images,
        YouTube_url: row.YouTube_url || undefined,
      };
    });

    // 3. Fetch products list for the "Product Review" dropdown
    const [prodRows] = await pool.query<RowDataPacket[]>(`
      SELECT id, product_name
      FROM tbl_product
      WHERE status = 1 AND is_deleted = 1
      ORDER BY id DESC
      LIMIT 40
    `);

    productsList = prodRows.map((p) => ({
      id: Number(p.id),
      name: String(p.product_name || `Product #${p.id}`),
    }));
  } catch (err) {
    console.error("Error fetching live reviews from MySQL:", err);
  }

  return (
    <ReviewClient
      initialReviews={initialReviews}
      initialStats={stats}
      productsList={productsList}
    />
  );
}
