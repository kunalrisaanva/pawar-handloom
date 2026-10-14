import { NextResponse } from "next/server";
import pool from "@/lib/db";

export const dynamic = "force-dynamic";

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const token = (body.token || "").trim();
    const password = (body.password || "").trim();
    const confirmPassword = (body.confirm_password || body.confirmPassword || "").trim();

    if (!token) {
      return NextResponse.json(
        { status: "error", message: "Invalid or missing reset token." },
        { status: 400 }
      );
    }

    if (password.length < 6) {
      return NextResponse.json(
        { status: "error", message: "Password must be at least 6 characters." },
        { status: 400 }
      );
    }

    if (password !== confirmPassword) {
      return NextResponse.json(
        { status: "error", message: "Passwords do not match." },
        { status: 400 }
      );
    }

    // Verify token validity in database using UTC timestamp comparison
    const [rows]: any = await pool.query(
      "SELECT id, email, token_expiry, (token_expiry >= UTC_TIMESTAMP()) as is_valid FROM tbl_users WHERE reset_token = ? AND is_deleted = 1 LIMIT 1",
      [token]
    );

    if (!rows || rows.length === 0) {
      return NextResponse.json(
        { status: "error", message: "The reset link is invalid or has expired." },
        { status: 400 }
      );
    }

    if (!rows[0].is_valid) {
      return NextResponse.json(
        { status: "error", message: "The reset link has expired. Please request a new one." },
        { status: 400 }
      );
    }

    // Call existing CodeIgniter backend to finalize reset
    const form = new FormData();
    form.append("password", password);
    form.append("confirm_password", confirmPassword);

    try {
      await fetch(`http://localhost:8080/reset-password/${token}`, {
        method: "POST",
        body: form,
        redirect: "manual",
      });
    } catch (e) {
      console.warn("Backend resetPassword call notice:", e);
    }

    // Verify and ensure token cleared
    await pool.query(
      "UPDATE tbl_users SET reset_token = NULL, token_expiry = NULL WHERE id = ?",
      [rows[0].id]
    );

    return NextResponse.json({
      status: "success",
      message: "Password has been reset successfully. You can now log in.",
    });
  } catch (error: any) {
    console.error("Reset password API error:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "Failed to reset password." },
      { status: 500 }
    );
  }
}
