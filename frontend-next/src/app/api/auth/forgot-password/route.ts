import { NextResponse } from "next/server";
import pool from "@/lib/db";

export const dynamic = "force-dynamic";

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const email = (body.email || "").trim().toLowerCase();

    if (!email || !email.includes("@")) {
      return NextResponse.json(
        { status: "error", message: "Please provide a valid email address." },
        { status: 400 }
      );
    }

    // 1. Check if user exists in live database
    const [rows]: any = await pool.query(
      "SELECT id, name, email FROM tbl_users WHERE email = ? AND is_deleted = 1 LIMIT 1",
      [email]
    );

    if (!rows || rows.length === 0) {
      return NextResponse.json(
        { status: "error", message: "No account found with this email address." },
        { status: 404 }
      );
    }

    const user = rows[0];

    // 2. Dispatch to existing CodeIgniter backend endpoint: /forgotPassword
    const form = new FormData();
    form.append("email", email);

    try {
      await fetch("http://localhost:8080/forgotPassword", {
        method: "POST",
        body: form,
        redirect: "manual",
      });
    } catch (backendErr) {
      console.warn("Backend /forgotPassword call warning:", backendErr);
    }

    // 3. Retrieve the generated token from MySQL for developer convenience
    const [updatedRows]: any = await pool.query(
      "SELECT reset_token FROM tbl_users WHERE id = ? LIMIT 1",
      [user.id]
    );
    const token = updatedRows?.[0]?.reset_token;
    const resetLink = token ? `http://localhost:3000/reset-password/${token}` : null;

    return NextResponse.json({
      status: "success",
      message: "A password reset link has been sent to your email address.",
      reset_link: resetLink,
    });
  } catch (error: any) {
    console.error("Forgot password API error:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "Failed to process request." },
      { status: 500 }
    );
  }
}
