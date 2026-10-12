import pool from "@/lib/db";
import ProductDetailClient from "./ProductDetailClient";
import SharedLayout from "../../../components/SharedLayout";
import { notFound } from "next/navigation";

export const dynamic = "force-dynamic";

export default async function ProductDetailPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;

  try {
    let [rows] = (await pool.query(
      "SELECT * FROM tbl_product WHERE id = ? AND is_deleted = 1 AND status = 1",
      [id]
    )) as any;

    if (!rows || rows.length === 0) {
      const [fallback] = (await pool.query(
        "SELECT * FROM tbl_product WHERE is_deleted = 1 AND status = 1 ORDER BY id ASC LIMIT 1"
      )) as any;
      if (fallback && fallback.length > 0) {
        rows = fallback;
      } else {
        return notFound();
      }
    }

    const product = rows[0];

    // Fetch additional gallery images
    const [imageRows] = (await pool.query(
      "SELECT * FROM tbl_product_image WHERE product_id = ? AND is_deleted = 1 AND status = 1 ORDER BY id ASC",
      [product.id]
    )) as any;

    // Fetch product colors
    let colorRows: any[] = [];
    if (product.colour) {
      const colorIds = product.colour
        .toString()
        .split(",")
        .map((c: string) => parseInt(c.trim(), 10))
        .filter((n: number) => !isNaN(n) && n > 0);

      if (colorIds.length > 0) {
        const [cRows] = (await pool.query(
          `SELECT * FROM tbl_colour WHERE id IN (${colorIds.map(() => "?").join(",")}) AND is_deleted = 1 AND status = 1`,
          colorIds
        )) as any;
        colorRows = cRows || [];
      }
    }

    // Fetch category name for breadcrumb
    let categoryName = "Sarees";
    if (product.category) {
      const [catRows] = (await pool.query(
        "SELECT category_name FROM tbl_category WHERE id = ? AND is_deleted = 1 LIMIT 1",
        [product.category]
      )) as any;
      if (catRows && catRows.length > 0 && catRows[0].category_name) {
        categoryName = catRows[0].category_name;
      }
    }

    // Fetch related products (same category, not same id, limit 4)
    const [relatedRows] = (await pool.query(
      "SELECT * FROM tbl_product WHERE category = ? AND id != ? AND is_deleted = 1 AND status = 1 ORDER BY RAND() LIMIT 4",
      [product.category, product.id]
    )) as any;

    // Pass to client component
    return (
      <SharedLayout>
        <ProductDetailClient
          product={product}
          images={imageRows || []}
          colors={colorRows || []}
          categoryName={categoryName}
          relatedProducts={relatedRows || []}
        />
      </SharedLayout>
    );

  } catch (error) {
    console.error("Database Error:", error);
    return notFound();
  }
}
