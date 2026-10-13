import { NextResponse } from "next/server";
import pool from "@/lib/db";

export const dynamic = "force-dynamic";

// GET: Fetch user profile, addresses, and order stats
export async function GET(request: Request) {
  try {
    const { searchParams } = new URL(request.url);
    const userIdParam = searchParams.get("userId");
    const emailParam = searchParams.get("email");

    let user: any = null;

    if (userIdParam) {
      const [rows]: any = await pool.query(
        "SELECT id, name, company_name, email, phone, whatsapp_no, address, role, status, is_deleted FROM tbl_users WHERE id = ? AND is_deleted = 1 LIMIT 1",
        [userIdParam]
      );
      if (rows && rows.length > 0) user = rows[0];
    } else if (emailParam) {
      const [rows]: any = await pool.query(
        "SELECT id, name, company_name, email, phone, whatsapp_no, address, role, status, is_deleted FROM tbl_users WHERE email = ? AND is_deleted = 1 LIMIT 1",
        [emailParam]
      );
      if (rows && rows.length > 0) user = rows[0];
    }

    // Default to active reseller (id 10) if not found or no param passed
    if (!user) {
      const [rows]: any = await pool.query(
        "SELECT id, name, company_name, email, phone, whatsapp_no, address, role, status, is_deleted FROM tbl_users WHERE role = 1 AND status = 1 AND is_deleted = 1 ORDER BY id ASC LIMIT 1"
      );
      if (rows && rows.length > 0) {
        user = rows[0];
      } else {
        // Fallback to first active user
        const [fallback]: any = await pool.query(
          "SELECT id, name, company_name, email, phone, whatsapp_no, address, role, status, is_deleted FROM tbl_users WHERE status = 1 AND is_deleted = 1 LIMIT 1"
        );
        user = fallback?.[0] || {
          id: 10,
          name: "User",
          email: "reseller@pawarhandloom.com",
          phone: "9876543210",
          whatsapp_no: "9876543210",
          role: 1,
          status: 1,
        };
      }
    }

    const userId = user.id;

    // Fetch user addresses
    const [addresses]: any = await pool.query(
      "SELECT * FROM tbl_user_address WHERE user_id = ? AND is_deleted = 0 ORDER BY is_default DESC, id DESC",
      [userId]
    );

    // Fetch user orders count
    const [orders]: any = await pool.query(
      "SELECT COUNT(*) as count FROM tbl_order WHERE login_user_id = ? AND is_deleted = 1",
      [userId]
    );

    const orderCount = orders?.[0]?.count || 0;

    return NextResponse.json({
      status: "success",
      user,
      addresses: addresses || [],
      addressCount: (addresses || []).length,
      orderCount,
    });
  } catch (error: any) {
    console.error("API Profile GET Error:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "Server error" },
      { status: 500 }
    );
  }
}

// POST: Update user profile or address actions
export async function POST(request: Request) {
  try {
    const body = await request.json();
    const { action, userId = 10 } = body;

    if (action === "update_profile") {
      const { name, phone, whatsapp_no, company_name } = body;
      await pool.query(
        "UPDATE tbl_users SET name = ?, phone = ?, whatsapp_no = ?, company_name = ? WHERE id = ?",
        [name || null, phone || "", whatsapp_no || "", company_name || "", userId]
      );
      return NextResponse.json({
        status: "success",
        message: "Profile updated successfully!",
      });
    }

    if (action === "add_address") {
      const {
        full_name,
        phone,
        alternate_phone = "",
        country = "India",
        state,
        city,
        pincode,
        house_no,
        street,
        landmark = "",
        address_type = "home",
        is_default = 0,
      } = body;

      // Count existing addresses (max 5)
      const [existing]: any = await pool.query(
        "SELECT COUNT(*) as count FROM tbl_user_address WHERE user_id = ? AND is_deleted = 0",
        [userId]
      );
      if ((existing?.[0]?.count || 0) >= 5) {
        return NextResponse.json(
          { status: "error", message: "You can save a maximum of 5 addresses." },
          { status: 400 }
        );
      }

      // If marked as default or first address, unset previous defaults
      const shouldBeDefault = is_default === 1 || (existing?.[0]?.count || 0) === 0 ? 1 : 0;
      if (shouldBeDefault === 1) {
        await pool.query(
          "UPDATE tbl_user_address SET is_default = 0 WHERE user_id = ?",
          [userId]
        );
      }

      const now = new Date();
      const [insertResult]: any = await pool.query(
        `INSERT INTO tbl_user_address 
          (user_id, full_name, phone, alternate_phone, country, state, city, pincode, house_no, street, landmark, address_type, is_default, status, is_deleted, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, ?, ?)`,
        [
          userId,
          full_name,
          phone,
          alternate_phone,
          country,
          state,
          city,
          pincode,
          house_no,
          street,
          landmark,
          address_type,
          shouldBeDefault,
          now,
          now,
        ]
      );

      return NextResponse.json({
        status: "success",
        message: "Address added successfully!",
        addressId: insertResult.insertId,
      });
    }

    if (action === "update_address") {
      const {
        addressId,
        full_name,
        phone,
        alternate_phone = "",
        country = "India",
        state,
        city,
        pincode,
        house_no,
        street,
        landmark = "",
        address_type = "home",
        is_default = 0,
      } = body;

      if (is_default === 1) {
        await pool.query(
          "UPDATE tbl_user_address SET is_default = 0 WHERE user_id = ?",
          [userId]
        );
      }

      const now = new Date();
      await pool.query(
        `UPDATE tbl_user_address 
         SET full_name = ?, phone = ?, alternate_phone = ?, country = ?, state = ?, city = ?, pincode = ?, house_no = ?, street = ?, landmark = ?, address_type = ?, is_default = ?, updated_at = ?
         WHERE id = ? AND user_id = ?`,
        [
          full_name,
          phone,
          alternate_phone,
          country,
          state,
          city,
          pincode,
          house_no,
          street,
          landmark,
          address_type,
          is_default,
          now,
          addressId,
          userId,
        ]
      );

      return NextResponse.json({
        status: "success",
        message: "Address updated successfully!",
      });
    }

    if (action === "delete_address") {
      const { addressId } = body;
      await pool.query(
        "UPDATE tbl_user_address SET is_deleted = 1 WHERE id = ? AND user_id = ?",
        [addressId, userId]
      );
      return NextResponse.json({
        status: "success",
        message: "Address removed successfully!",
      });
    }

    if (action === "set_default_address") {
      const { addressId } = body;
      await pool.query(
        "UPDATE tbl_user_address SET is_default = 0 WHERE user_id = ?",
        [userId]
      );
      await pool.query(
        "UPDATE tbl_user_address SET is_default = 1 WHERE id = ? AND user_id = ?",
        [addressId, userId]
      );
      return NextResponse.json({
        status: "success",
        message: "Default address set successfully!",
      });
    }

    return NextResponse.json(
      { status: "error", message: "Invalid action" },
      { status: 400 }
    );
  } catch (error: any) {
    console.error("API Profile POST Error:", error);
    return NextResponse.json(
      { status: "error", message: error.message || "Server error" },
      { status: 500 }
    );
  }
}
