import pool from "@/lib/db";
import HomePageClient from "./HomePageClient";

export const dynamic = "force-dynamic";

export default async function HomePage() {
  try {
    // 1. Fetch Sliders
    const [sliderRows] = await pool.query(
      "SELECT * FROM tbl_slider WHERE is_deleted = 1 AND status = 1"
    );

    // 2. Fetch New Arrivals (category 6)
    const [newArrivalsRows] = await pool.query(
      "SELECT * FROM tbl_product WHERE category = 6 AND is_deleted = 1 AND status = 1 ORDER BY id DESC LIMIT 4"
    );

    // 3. Fetch Best Sellers (category 7)
    const [bestSellersRows] = await pool.query(
      "SELECT * FROM tbl_product WHERE category = 7 AND is_deleted = 1 AND status = 1 LIMIT 4"
    );

    // 4. Fetch Dress Material (category 3)
    const [dressMaterialRows] = await pool.query(
      "SELECT * FROM tbl_product WHERE category = 3 AND is_deleted = 1 AND status = 1 LIMIT 4"
    );

    // 5. Fetch See it Love it (category 2)
    const [seeItLoveItRows] = await pool.query(
      "SELECT * FROM tbl_product WHERE category = 2 AND is_deleted = 1 AND status = 1 LIMIT 4"
    );

    // 6. Fetch Celebs Look (category 8)
    const [celebsLookRows] = await pool.query(
      "SELECT * FROM tbl_product WHERE category = 8 AND is_deleted = 1 AND status = 1 LIMIT 4"
    );

    // Pass the fetched database records to the Client Component
    return (
      <HomePageClient 
        serverSliders={sliderRows as any[]} 
        serverNewArrivals={newArrivalsRows as any[]}
        serverBestSellers={bestSellersRows as any[]}
        serverDressMaterial={dressMaterialRows as any[]}
        serverSeeItLoveIt={seeItLoveItRows as any[]}
        serverCelebsLook={celebsLookRows as any[]}
      />
    );
  } catch (error) {
    console.error("Database connection failed:", error);
    return (
      <div className="p-8 text-center text-red-500">
        <h2>Failed to connect to the database.</h2>
        <p>Please check your MySQL connection and credentials.</p>
      </div>
    );
  }
}
