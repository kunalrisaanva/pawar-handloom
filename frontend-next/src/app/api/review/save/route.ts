import { NextResponse } from "next/server";
import pool from "@/lib/db";
import { ResultSetHeader } from "mysql2";
import fs from "fs/promises";
import path from "path";

export async function POST(req: Request) {
  try {
    const formData = await req.formData();

    const rating = Math.min(5, Math.max(1, parseInt((formData.get("rating") as string) || "5")));
    const review_title = ((formData.get("review_title") as string) || "").trim();
    const review_text = ((formData.get("review_text") as string) || "").trim();
    const review_type = parseInt((formData.get("review_type") as string) || "2"); // 1 = Product, 2 = Shop
    const product_id = parseInt((formData.get("product_id") as string) || "0");
    const user_id = parseInt((formData.get("user_id") as string) || "0");
    const name = ((formData.get("name") as string) || "Customer").trim();
    const email = ((formData.get("email") as string) || "").trim();
    const youTube_url = ((formData.get("YouTube_url") as string) || "").trim();

    if (!review_title || !review_text) {
      return NextResponse.json(
        { status: "error", message: "Review title and content are required." },
        { status: 400 }
      );
    }

    // Insert into tbl_review
    const [result] = await pool.query<ResultSetHeader>(
      `INSERT INTO tbl_review (
        user_id, product_id, review_title, rating, review_text,
        YouTube_url, name, email, review_type, likes, status, is_deleted, created_at
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 1, 1, NOW())`,
      [
        user_id,
        product_id,
        review_title,
        rating,
        review_text,
        youTube_url,
        name,
        email,
        review_type,
      ]
    );

    const reviewId = result.insertId;

    // Handle uploaded images
    const files = formData.getAll("review_images") as File[];
    const savedImageNames: string[] = [];

    // Target upload folder in public/uploads/review_images
    const uploadDir = path.resolve(process.cwd(), "../public/uploads/review_images");

    try {
      await fs.mkdir(uploadDir, { recursive: true });
    } catch (e) {
      // folder exists
    }

    for (const file of files) {
      if (file && typeof file === "object" && file.size > 0 && file.name) {
        const ext = path.extname(file.name) || ".jpg";
        const randomName = `${Date.now()}_${Math.random().toString(36).substring(2, 10)}${ext}`;
        const filePath = path.join(uploadDir, randomName);

        const bytes = await file.arrayBuffer();
        const buffer = Buffer.from(bytes);
        await fs.writeFile(filePath, buffer);

        savedImageNames.push(randomName);

        // Insert into tbl_review_image
        await pool.query<ResultSetHeader>(
          `INSERT INTO tbl_review_image (
            review_id, user_id, product_id, review_image, review_type, status, is_deleted, created_at
          ) VALUES (?, ?, ?, ?, ?, 1, 1, NOW())`,
          [reviewId, user_id, product_id, randomName, review_type]
        );
      }
    }

    return NextResponse.json({
      status: "success",
      message: "Review submitted successfully",
      review: {
        id: reviewId,
        user_id,
        product_id,
        name,
        email,
        review_title,
        review_text,
        rating,
        review_type,
        likes: 0,
        created_at: new Date().toISOString(),
        review_images: savedImageNames,
        YouTube_url: youTube_url,
      },
    });
  } catch (error: any) {
    console.error("Error saving review:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "Failed to submit review" },
      { status: 500 }
    );
  }
}
