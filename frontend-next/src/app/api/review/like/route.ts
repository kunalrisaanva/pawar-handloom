import { NextResponse } from "next/server";
import pool from "@/lib/db";
import { RowDataPacket, ResultSetHeader } from "mysql2";

export async function POST(req: Request) {
  try {
    const body = await req.json();
    const reviewId = Number(body.id);

    if (!reviewId || isNaN(reviewId)) {
      return NextResponse.json(
        { status: "error", message: "Invalid review ID" },
        { status: 400 }
      );
    }

    // Increment likes safely (matching CodeIgniter like function)
    await pool.query<ResultSetHeader>(
      "UPDATE tbl_review SET likes = COALESCE(likes, 0) + 1 WHERE id = ?",
      [reviewId]
    );

    // Fetch updated like count
    const [rows] = await pool.query<RowDataPacket[]>(
      "SELECT likes FROM tbl_review WHERE id = ?",
      [reviewId]
    );

    const newLikes = rows[0]?.likes ?? 0;

    return NextResponse.json({
      status: "success",
      likes: newLikes,
    });
  } catch (error: any) {
    console.error("Error updating review likes:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "Failed to like review" },
      { status: 500 }
    );
  }
}
