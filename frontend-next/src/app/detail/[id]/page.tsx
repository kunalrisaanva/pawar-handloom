import pool from "@/lib/db";
import ProductDetailClient from "./ProductDetailClient";
import SharedLayout from "../../../components/SharedLayout";
import { notFound } from "next/navigation";

export const dynamic = "force-dynamic";

export default async function ProductDetailPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;

  try {
    const [rows] = await pool.query(
      "SELECT * FROM tbl_product WHERE id = ? AND is_deleted = 1 AND status = 1",
      [id]
    ) as any;

    if (!rows || rows.length === 0) {
      return notFound();
    }

    const product = rows[0];

    // Fetch related products (same category, not same id, limit 4)
    const [relatedRows] = await pool.query(
      "SELECT * FROM tbl_product WHERE category = ? AND id != ? AND is_deleted = 1 AND status = 1 ORDER BY RAND() LIMIT 4",
      [product.category, id]
    ) as any;

    // Pass to client component
    return (
      <SharedLayout>
        <ProductDetailClient product={product} relatedProducts={relatedRows || []} />
      </SharedLayout>
    );

  } catch (error) {
    console.error("Database Error:", error);
    return notFound();
  }
}
