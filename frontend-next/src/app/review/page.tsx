import pool from "@/lib/db";
import ReviewClient, { ReviewItem, ReviewStats } from "./ReviewClient";

export const dynamic = "force-dynamic";

export const metadata = {
  title: "Customer Reviews & Experiences | Pawar Handloom",
  description:
    "Authentic reviews and ratings from our customers on Maheshwari and Chanderi handloom sarees, suits, and store experiences.",
};

export default async function ReviewPage() {
  let reviews: ReviewItem[] = [];
  let stats: ReviewStats = {
    averageRating: 0,
    totalReviews: 0,
    ratingCounts: { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 },
  };

  try {
    // 1. Fetch reviews with joined images and product name (matching CodeIgniter review_helper)
    const [reviewRows] = (await pool.query(`
      SELECT 
        r.id,
        r.user_id,
        r.product_id,
        r.review_title,
        r.rating,
        r.review_text,
        r.YouTube_url,
        r.name,
        r.email,
        r.review_type,
        r.likes,
        r.status,
        r.is_deleted,
        r.created_at,
        GROUP_CONCAT(ri.review_image) as review_images,
        p.product_name
      FROM tbl_review r
      LEFT JOIN tbl_review_image ri ON ri.review_id = r.id AND ri.status = 1 AND ri.is_deleted = 1
      LEFT JOIN tbl_product p ON p.id = r.product_id
      WHERE r.status = 1 AND r.is_deleted = 1
      GROUP BY r.id
      ORDER BY r.created_at DESC
    `)) as any;

    // 2. Fetch stats (matching CodeIgniter FrontendModel::getReviewStats)
    const [statsRows] = (await pool.query(`
      SELECT rating, COUNT(*) as count 
      FROM tbl_review 
      WHERE status = 1 AND is_deleted = 1 
      GROUP BY rating
    `)) as any;

    const ratingCounts: Record<number, number> = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
    let totalCount = 0;
    let totalScore = 0;

    (statsRows || []).forEach((row: { rating: number; count: number }) => {
      const r = Number(row.rating);
      const c = Number(row.count);
      if (r >= 1 && r <= 5) {
        ratingCounts[r] = c;
        totalCount += c;
        totalScore += r * c;
      }
    });

    const averageRating = totalCount > 0 ? Number((totalScore / totalCount).toFixed(1)) : 0;

    stats = {
      averageRating,
      totalReviews: (reviewRows || []).length,
      ratingCounts,
    };

    reviews = (reviewRows || []).map((row: any) => {
      const imgList = row.review_images
        ? row.review_images
            .split(",")
            .map((img: string) => img.trim())
            .filter(Boolean)
            .map((img: string) =>
              img.startsWith("http")
                ? img
                : `http://localhost:8080/public/uploads/review_images/${img}`
            )
        : [];

      return {
        id: Number(row.id),
        user_id: Number(row.user_id || 0),
        product_id: Number(row.product_id || 0),
        product_name: row.product_name || (Number(row.product_id) > 0 ? `Product #${row.product_id}` : undefined),
        name: row.name?.trim() || "Verified Customer",
        email: row.email || "",
        rating: Math.max(1, Math.min(5, Number(row.rating || 5))),
        review_title: row.review_title?.trim() || "Customer Experience",
        review_text: row.review_text?.trim() || "",
        review_type: Number(row.review_type) === 1 ? 1 : 2,
        likes: Number(row.likes || 0),
        created_at: row.created_at ? new Date(row.created_at).toISOString() : new Date().toISOString(),
        verified: true,
        review_images: imgList,
        YouTube_url: row.YouTube_url || "",
      };
    });
  } catch (error) {
    console.error("Database query failed in ReviewPage, fallback will query API:", error);
  }

  return <ReviewClient initialReviews={reviews} initialStats={stats} />;
}
