import pool from "@/lib/db";
import SharedLayout from "@/components/SharedLayout";
import NewArrivalsClient from "@/app/new-arrivals/NewArrivalsClient";
import { redirect } from "next/navigation";

export const dynamic = "force-dynamic";

export default async function ShopCategoryPage({
  params,
}: {
  params: Promise<{ id: string }>;
}) {
  const { id } = await params;

  // If user visits /shop/6 (New Arrivals in original DB), redirect cleanly to /new-arrivals
  if (id === "6") {
    redirect("/new-arrivals");
  }

  // Otherwise, fetch products for this category
  try {
    const [catRows] = (await pool.query(
      `SELECT * FROM tbl_category WHERE id = ? AND is_deleted = 1 LIMIT 1`,
      [id]
    )) as any;

    const categoryInfo = catRows?.[0] || {
      id: Number(id),
      category_name: "Collection",
      category_description: "Explore our authentic handcrafted collection",
    };

    const [productRows] = (await pool.query(
      `SELECT p.*, c.category_name 
       FROM tbl_product p
       LEFT JOIN tbl_category c ON c.id = p.category
       WHERE p.category = ? AND p.is_deleted = 1 AND p.status = 1
       ORDER BY p.id DESC`,
      [id]
    )) as any;

    return (
      <SharedLayout>
        <NewArrivalsClient
          initialProducts={productRows || []}
          categoryInfo={categoryInfo}
        />
      </SharedLayout>
    );
  } catch (error) {
    console.error("Shop category error:", error);
    redirect("/new-arrivals");
  }
}
