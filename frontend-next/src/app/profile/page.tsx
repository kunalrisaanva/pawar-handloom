import pool from "@/lib/db";
import SharedLayout from "@/components/SharedLayout";
import ProfileClient from "./ProfileClient";
import { Metadata } from "next";

export const dynamic = "force-dynamic";

export const metadata: Metadata = {
  title: "My Profile - Account & Addresses | Pawar Handloom",
  description: "Manage your Pawar Handloom profile and saved delivery addresses.",
};

export default async function ProfilePage() {
  try {
    // 1. Fetch user (prioritize active reseller id 10 or first active user)
    const [userRows]: any = await pool.query(
      "SELECT id, name, company_name, email, phone, whatsapp_no, address, role, status, is_deleted FROM tbl_users WHERE role = 1 AND status = 1 AND is_deleted = 1 ORDER BY id ASC LIMIT 1"
    );

    const user = userRows?.[0] || {
      id: 10,
      name: "User",
      company_name: "",
      email: "reseller@pawarhandloom.com",
      phone: "9876543210",
      whatsapp_no: "9876543210",
      role: 1,
      status: 1,
    };

    // 2. Fetch addresses for user
    const [addressRows]: any = await pool.query(
      "SELECT * FROM tbl_user_address WHERE user_id = ? AND is_deleted = 0 ORDER BY is_default DESC, id DESC",
      [user.id]
    );

    // 3. Fetch order count
    const [orderRows]: any = await pool.query(
      "SELECT COUNT(*) as count FROM tbl_order WHERE login_user_id = ? AND is_deleted = 1",
      [user.id]
    );

    const orderCount = orderRows?.[0]?.count || 0;

    return (
      <SharedLayout>
        <ProfileClient
          initialUser={user}
          initialAddresses={addressRows || []}
          initialOrderCount={orderCount}
        />
      </SharedLayout>
    );
  } catch (err) {
    console.error("Profile page DB error:", err);
    return (
      <SharedLayout>
        <ProfileClient
          initialUser={{
            id: 10,
            name: "User",
            company_name: "",
            email: "reseller@pawarhandloom.com",
            phone: "9876543210",
            whatsapp_no: "9876543210",
            role: 1,
            status: 1,
          }}
          initialAddresses={[]}
          initialOrderCount={0}
        />
      </SharedLayout>
    );
  }
}
