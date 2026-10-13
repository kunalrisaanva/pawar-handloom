import pool from "@/lib/db";
import SharedLayout from "@/components/SharedLayout";
import NewArrivalsClient from "@/app/new-arrivals/NewArrivalsClient";
import { redirect } from "next/navigation";
import { Metadata } from "next";

export const dynamic = "force-dynamic";

interface PageProps {
  params: Promise<{ slug?: string[] }>;
}

export async function generateMetadata({ params }: PageProps): Promise<Metadata> {
  const { slug } = await params;
  if (!slug || slug.length === 0) {
    return {
      title: "All Collections | Pawar Handloom",
      description: "Explore authentic handwoven Maheshwari and Chanderi sarees & suits.",
    };
  }

  const catId = slug[0];
  const subCatId = slug[1];
  const subSubCatId = slug[2];

  try {
    if (subSubCatId && !isNaN(Number(subSubCatId))) {
      const [rows]: any = await pool.query(
        "SELECT name, subsubCategory_description FROM tbl_subsubcategory WHERE id = ? LIMIT 1",
        [subSubCatId]
      );
      if (rows?.[0]) {
        return {
          title: `${rows[0].name} | Pawar Handloom`,
          description: rows[0].subsubCategory_description || `Shop authentic ${rows[0].name}`,
        };
      }
    }

    if (subCatId && !isNaN(Number(subCatId))) {
      const [rows]: any = await pool.query(
        "SELECT name, subCategory_description FROM tbl_subcategory WHERE id = ? LIMIT 1",
        [subCatId]
      );
      if (rows?.[0]) {
        return {
          title: `${rows[0].name} | Pawar Handloom`,
          description: rows[0].subCategory_description || `Shop authentic ${rows[0].name}`,
        };
      }
    }

    if (catId && !isNaN(Number(catId))) {
      const [rows]: any = await pool.query(
        "SELECT category_name, category_description FROM tbl_category WHERE id = ? LIMIT 1",
        [catId]
      );
      if (rows?.[0]) {
        return {
          title: `${rows[0].category_name} | Pawar Handloom`,
          description: rows[0].category_description || `Shop authentic ${rows[0].category_name}`,
        };
      }
    }
  } catch (e) {
    console.error("Metadata error:", e);
  }

  return {
    title: "Handloom Collection | Pawar Handloom",
    description: "Explore our handcrafted collection.",
  };
}

export default async function ShopCategoryPage({ params }: PageProps) {
  const { slug } = await params;

  // 1. If /shop with no slug: fetch all active products
  if (!slug || slug.length === 0) {
    try {
      const [productRows]: any = await pool.query(
        `SELECT p.*, c.category_name, sc.name AS subcategory_name, ssc.name AS subsubcategory_name
         FROM tbl_product p
         LEFT JOIN tbl_category c ON c.id = p.category
         LEFT JOIN tbl_subcategory sc ON sc.id = p.subcategory
         LEFT JOIN tbl_subsubcategory ssc ON ssc.id = p.sub_subCategory
         WHERE p.is_deleted = 1 AND p.status = 1
         ORDER BY p.id DESC`
      );

      return (
        <SharedLayout>
          <NewArrivalsClient
            initialProducts={productRows || []}
            categoryInfo={{
              id: 0,
              category_name: "All Collections",
              category_description:
                "Explore our complete range of exquisite handwoven Maheshwari sarees, Chanderi weaves, and royal dress materials.",
              badge: "Complete Collection",
            }}
          />
        </SharedLayout>
      );
    } catch (error) {
      console.error("Shop all products error:", error);
      redirect("/new-arrivals");
    }
  }

  const catParam = slug[0];
  const subCatParam = slug[1];
  const subSubCatParam = slug[2];

  // 2. If user visits /shop/6 (New Arrivals in original DB), redirect cleanly to /new-arrivals
  if (catParam === "6") {
    redirect("/new-arrivals");
  }

  try {
    let categoryInfo: {
      id?: number;
      category_name: string;
      category_description?: string;
      parent_category?: string;
      parent_href?: string;
      badge?: string;
    } = {
      category_name: "Collection",
      category_description: "Explore our authentic handcrafted collection",
    };

    let productRows: any[] = [];

    // CASE A: 3-level slug e.g. /shop/2/1/1 (Category -> Subcategory -> Sub-Subcategory)
    if (subSubCatParam) {
      const [subsubRows]: any = await pool.query(
        `SELECT ssc.*, sc.name AS sub_name, c.category_name AS parent_category_name, c.id AS parent_cat_id
         FROM tbl_subsubcategory ssc
         LEFT JOIN tbl_subcategory sc ON sc.id = ssc.sub_cat_id
         LEFT JOIN tbl_category c ON c.id = ssc.cat_id
         WHERE ssc.id = ? AND ssc.is_deleted = 1
         LIMIT 1`,
        [subSubCatParam]
      );

      if (subsubRows && subsubRows.length > 0) {
        const item = subsubRows[0];
        categoryInfo = {
          id: item.id,
          category_name: item.name,
          category_description:
            item.subsubCategory_description && item.subsubCategory_description !== "Testing here..." && item.subsubCategory_description !== "Testing..."
              ? item.subsubCategory_description
              : `Handwoven ${item.name} handcrafted by master artisans in Maheshwar.`,
          parent_category: item.sub_name || item.parent_category_name || "Sarees",
          parent_href: `/shop/${item.parent_cat_id || catParam}/${item.sub_cat_id || subCatParam}`,
          badge: item.name,
        };
      }

      const [pRows]: any = await pool.query(
        `SELECT p.*, c.category_name, sc.name AS subcategory_name, ssc.name AS subsubcategory_name
         FROM tbl_product p
         LEFT JOIN tbl_category c ON c.id = p.category
         LEFT JOIN tbl_subcategory sc ON sc.id = p.subcategory
         LEFT JOIN tbl_subsubcategory ssc ON ssc.id = p.sub_subCategory
         WHERE p.category = ? AND p.subcategory = ? AND p.sub_subCategory = ? AND p.is_deleted = 1 AND p.status = 1
         ORDER BY p.id DESC`,
        [catParam, subCatParam, subSubCatParam]
      );

      productRows = pRows || [];

      // If no products found specifically for sub-subcategory, fallback to subcategory products
      if (productRows.length === 0) {
        const [fallback]: any = await pool.query(
          `SELECT p.*, c.category_name, sc.name AS subcategory_name, ssc.name AS subsubcategory_name
           FROM tbl_product p
           LEFT JOIN tbl_category c ON c.id = p.category
           LEFT JOIN tbl_subcategory sc ON sc.id = p.subcategory
           LEFT JOIN tbl_subsubcategory ssc ON ssc.id = p.sub_subCategory
           WHERE p.category = ? AND p.subcategory = ? AND p.is_deleted = 1 AND p.status = 1
           ORDER BY p.id DESC`,
          [catParam, subCatParam]
        );
        productRows = fallback || [];
      }
    }

    // CASE B: 2-level slug e.g. /shop/2/1 (Category -> Subcategory e.g. Maheshwari Sarees, Chanderi Sarees)
    else if (subCatParam) {
      const [subRows]: any = await pool.query(
        `SELECT sc.*, c.category_name AS parent_category_name, c.id AS parent_cat_id
         FROM tbl_subcategory sc
         LEFT JOIN tbl_category c ON c.id = sc.cat_id
         WHERE sc.id = ? AND sc.is_deleted = 1
         LIMIT 1`,
        [subCatParam]
      );

      let subcatName = "";
      if (subRows && subRows.length > 0) {
        const item = subRows[0];
        subcatName = item.name;
        categoryInfo = {
          id: item.id,
          category_name: item.name,
          category_description:
            item.subCategory_description && !item.subCategory_description.includes("Testing") && !item.subCategory_description.includes("Test Ddescription")
              ? item.subCategory_description
              : `Discover authentic handwoven ${item.name} featuring signature borders and heritage handloom craftsmanship.`,
          parent_category: item.parent_category_name || "Sarees",
          parent_href: `/shop/${item.parent_cat_id || catParam}`,
          badge: item.name,
        };
      }

      // Query products by category and subcategory
      const [pRows]: any = await pool.query(
        `SELECT p.*, c.category_name, sc.name AS subcategory_name, ssc.name AS subsubcategory_name
         FROM tbl_product p
         LEFT JOIN tbl_category c ON c.id = p.category
         LEFT JOIN tbl_subcategory sc ON sc.id = p.subcategory
         LEFT JOIN tbl_subsubcategory ssc ON ssc.id = p.sub_subCategory
         WHERE p.category = ? AND p.subcategory = ? AND p.is_deleted = 1 AND p.status = 1
         ORDER BY p.id DESC`,
        [catParam, subCatParam]
      );

      productRows = pRows || [];

      // If 0 products matched by exact subcategory ID (e.g. subcategory 3 Handblock or 5 Cotton):
      // Intelligently find related products by fabric, material, or keyword match!
      if (productRows.length === 0 && subcatName) {
        const keyword = subcatName
          .toLowerCase()
          .replace(/sarees|saree|dress material/gi, "")
          .trim();

        if (keyword) {
          const [kwRows]: any = await pool.query(
            `SELECT p.*, c.category_name, sc.name AS subcategory_name, ssc.name AS subsubcategory_name
             FROM tbl_product p
             LEFT JOIN tbl_category c ON c.id = p.category
             LEFT JOIN tbl_subcategory sc ON sc.id = p.subcategory
             LEFT JOIN tbl_subsubcategory ssc ON ssc.id = p.sub_subCategory
             WHERE p.category = ? 
               AND (p.product_name LIKE ? OR p.fabric_type LIKE ? OR p.material LIKE ? OR p.description LIKE ?)
               AND p.is_deleted = 1 AND p.status = 1
             ORDER BY p.id DESC`,
            [catParam, `%${keyword}%`, `%${keyword}%`, `%${keyword}%`, `%${keyword}%`]
          );
          if (kwRows && kwRows.length > 0) {
            productRows = kwRows;
          }
        }
      }
    }

    // CASE C: 1-level slug e.g. /shop/2 (Category e.g. Sarees, Dress material, Best Sellers)
    else {
      // Check if numeric ID or name string
      let catIdNumber = Number(catParam);

      if (isNaN(catIdNumber)) {
        // Find category by slug name e.g. 'sarees' or 'dress-material'
        const cleanName = catParam.replace(/-/g, " ");
        const [foundCat]: any = await pool.query(
          `SELECT id, category_name, category_description FROM tbl_category 
           WHERE LOWER(category_name) LIKE ? AND is_deleted = 1 LIMIT 1`,
          [`%${cleanName}%`]
        );
        if (foundCat && foundCat.length > 0) {
          catIdNumber = foundCat[0].id;
        }
      }

      const [catRows]: any = await pool.query(
        `SELECT * FROM tbl_category WHERE id = ? AND is_deleted = 1 LIMIT 1`,
        [catIdNumber]
      );

      if (catRows && catRows.length > 0) {
        const item = catRows[0];
        categoryInfo = {
          id: item.id,
          category_name: item.category_name,
          category_description:
            item.category_description ||
            `Exquisite handcrafted collection of ${item.category_name} by Pawar Handloom.`,
          badge: item.category_name,
        };
      }

      const [pRows]: any = await pool.query(
        `SELECT p.*, c.category_name, sc.name AS subcategory_name, ssc.name AS subsubcategory_name
         FROM tbl_product p
         LEFT JOIN tbl_category c ON c.id = p.category
         LEFT JOIN tbl_subcategory sc ON sc.id = p.subcategory
         LEFT JOIN tbl_subsubcategory ssc ON ssc.id = p.sub_subCategory
         WHERE p.category = ? AND p.is_deleted = 1 AND p.status = 1
         ORDER BY p.id DESC`,
        [catIdNumber]
      );

      productRows = pRows || [];
    }

    return (
      <SharedLayout>
        <NewArrivalsClient
          initialProducts={productRows || []}
          categoryInfo={categoryInfo}
        />
      </SharedLayout>
    );
  } catch (error) {
    console.error("Shop category route error:", error);
    redirect("/new-arrivals");
  }
}
