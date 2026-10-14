import pool from "@/lib/db";
import SharedLayout from "@/components/SharedLayout";
import NewArrivalsClient from "./NewArrivalsClient";
import { Metadata } from "next";

export const dynamic = "force-dynamic";

export const metadata: Metadata = {
  title: "New Arrivals - Fresh Handwoven Sarees & Suits | Pawar Handloom",
  description:
    "Discover the latest collection of authentic Maheshwari silk cotton sarees, zari tissue pallu sarees, and handcrafted dress materials fresh from the looms.",
};

export default async function NewArrivalsPage() {
  try {
    // 1. Fetch products: prioritize category 6 (official New Arrivals), then latest active products
    const [productRows] = (await pool.query(
      `SELECT p.*, c.category_name 
       FROM tbl_product p
       LEFT JOIN tbl_category c ON c.id = p.category
       WHERE p.is_deleted = 1 AND p.status = 1 
         AND (p.actual_price > 100 OR p.actual_price_customer > 100)
         AND p.cover_image IS NOT NULL AND p.cover_image != ""
       ORDER BY (CASE WHEN p.category = 6 THEN 0 ELSE 1 END), p.id DESC
       LIMIT 48`
    )) as any;

    // 2. Fetch category details for category 6 (New Arrivals)
    const [catRows] = (await pool.query(
      `SELECT * FROM tbl_category WHERE id = 6 AND is_deleted = 1 LIMIT 1`
    )) as any;

    const categoryInfo = catRows?.[0] || {
      id: 6,
      category_name: "New Arrivals",
      category_description:
        "Handcrafted with royal heritage by master weavers of Maheshwar.",
    };

    return (
      <SharedLayout>
        <NewArrivalsClient
          initialProducts={productRows || []}
          categoryInfo={categoryInfo}
        />
      </SharedLayout>
    );
  } catch (error) {
    console.error("Database Error on New Arrivals:", error);
    return (
      <SharedLayout>
        <NewArrivalsClient
          initialProducts={[]}
          categoryInfo={{
            id: 6,
            category_name: "New Arrivals",
            category_description:
              "Handcrafted with royal heritage by master weavers of Maheshwar.",
          }}
        />
      </SharedLayout>
    );
  }
}
