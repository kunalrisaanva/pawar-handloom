import { NextResponse } from "next/server";
import pool from "@/lib/db";

export const dynamic = "force-dynamic";

export async function POST(request: Request) {
  try {
    let name = "";
    let email = "";
    let subject_type = "General Inquiry";
    let message = "";

    const contentType = request.headers.get("content-type") || "";
    if (contentType.includes("application/json")) {
      const body = await request.json();
      name = (body.name || "").trim();
      email = (body.email || "").trim().toLowerCase();
      subject_type = (body.subject_type || "General Inquiry").trim();
      message = (body.message || "").trim();
    } else {
      const formData = await request.formData();
      name = (formData.get("name")?.toString() || "").trim();
      email = (formData.get("email")?.toString() || "").trim().toLowerCase();
      subject_type = (formData.get("subject_type")?.toString() || "General Inquiry").trim();
      message = (formData.get("message")?.toString() || "").trim();
    }

    // Validation
    if (!name || name.length < 2) {
      return NextResponse.json(
        { status: "error", message: "Please provide your full name." },
        { status: 400 }
      );
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
      return NextResponse.json(
        { status: "error", message: "Please provide a valid email address." },
        { status: 400 }
      );
    }

    if (!message || message.length < 5) {
      return NextResponse.json(
        { status: "error", message: "Please enter a message of at least 5 characters." },
        { status: 400 }
      );
    }

    // Dispatch to CodeIgniter backend (POST /contact)
    // CodeIgniter's HomeController::contact() inserts the row into tbl_contact
    // and sends HTML notification emails to both the customer and admin (pradeepdhakad543@gmail.com).
    let backendProcessed = false;
    try {
      const ciForm = new FormData();
      ciForm.append("name", name);
      ciForm.append("email", email);
      ciForm.append("subject_type", subject_type);
      ciForm.append("message", message);
      ciForm.append("contactSubmit", "1");

      const backendUrl = process.env.BACKEND_URL || "http://localhost:8080";
      const ciRes = await fetch(`${backendUrl}/contact`, {
        method: "POST",
        body: ciForm,
        redirect: "manual",
        signal: AbortSignal.timeout(5000),
      });

      // CodeIgniter redirects to /contact with 303/302 on successful submission
      if (ciRes.status === 303 || ciRes.status === 302 || ciRes.status === 200) {
        backendProcessed = true;
      }
    } catch (backendErr) {
      console.warn("Backend /contact dispatch notice:", backendErr);
    }

    // If backend didn't process it (e.g., CI server offline or timed out),
    // ensure the customer's query is never lost by saving directly to MySQL.
    if (!backendProcessed) {
      try {
        await pool.query(
          "INSERT INTO tbl_contact (name, email, subject_type, message, status, is_deleted) VALUES (?, ?, ?, ?, 1, 1)",
          [name, email, subject_type, message]
        );
      } catch (dbErr) {
        console.error("Direct MySQL insert error for tbl_contact:", dbErr);
        return NextResponse.json(
          { status: "error", message: "Unable to save your message right now. Please try again." },
          { status: 500 }
        );
      }
    }

    return NextResponse.json({
      status: "success",
      message: "Thank you! Your message has been sent successfully. We will get in touch with you soon.",
    });
  } catch (error: any) {
    console.error("Contact API error:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "An unexpected error occurred." },
      { status: 500 }
    );
  }
}
