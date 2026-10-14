"use client";

import React, { useState, useEffect } from "react";
import {
  User,
  ShoppingBag,
  MapPin,
  ChevronRight,
  Phone,
  MessageCircle,
  Mail,
  Camera,
  CheckCircle,
  Plus,
  Home,
  Building,
  Check,
  Trash2,
  Edit2,
  Save,
  X,
  AlertCircle,
  LogOut,
} from "lucide-react";
import { logoutUser } from "@/lib/auth";

interface UserData {
  id: number;
  name: string | null;
  company_name?: string | null;
  email: string;
  phone: string | null;
  whatsapp_no: string | null;
  address?: string | null;
  role: number;
  status: number;
}

interface AddressItem {
  id: number;
  user_id: number;
  full_name: string;
  phone: string;
  alternate_phone?: string;
  country: string;
  state: string;
  city: string;
  pincode: string;
  house_no: string;
  street: string;
  landmark?: string;
  address_type: "home" | "office" | "other";
  is_default: number;
}

interface ProfileClientProps {
  initialUser: UserData;
  initialAddresses: AddressItem[];
  initialOrderCount: number;
}

export default function ProfileClient({
  initialUser,
  initialAddresses = [],
  initialOrderCount = 0,
}: ProfileClientProps) {
  const [user, setUser] = useState<UserData>(initialUser);
  const [addresses, setAddresses] = useState<AddressItem[]>(initialAddresses);
  const [orderCount, setOrderCount] = useState<number>(initialOrderCount);

  // Form states
  const [name, setName] = useState<string>(initialUser.name || "");
  const [phone, setPhone] = useState<string>(initialUser.phone || "9876543210");
  const [whatsapp, setWhatsapp] = useState<string>(
    initialUser.whatsapp_no || "9876543210"
  );
  const [sameWhatsapp, setSameWhatsapp] = useState<boolean>(
    (initialUser.phone && initialUser.phone === initialUser.whatsapp_no) || true
  );
  const [updating, setUpdating] = useState<boolean>(false);
  const [toastMessage, setToastMessage] = useState<string | null>(null);

  // Address Modal state
  const [showAddressModal, setShowAddressModal] = useState<boolean>(false);
  const [editingAddressId, setEditingAddressId] = useState<number | null>(null);
  const [addrFullName, setAddrFullName] = useState("");
  const [addrPhone, setAddrPhone] = useState("");
  const [addrAltPhone, setAddrAltPhone] = useState("");
  const [addrCountry, setAddrCountry] = useState("India");
  const [addrState, setAddrState] = useState("");
  const [addrCity, setAddrCity] = useState("");
  const [addrPincode, setAddrPincode] = useState("");
  const [addrHouseNo, setAddrHouseNo] = useState("");
  const [addrStreet, setAddrStreet] = useState("");
  const [addrLandmark, setAddrLandmark] = useState("");
  const [addrType, setAddrType] = useState<"home" | "office" | "other">("home");
  const [addrIsDefault, setAddrIsDefault] = useState<boolean>(false);
  const [savingAddress, setSavingAddress] = useState<boolean>(false);

  const showToast = (msg: string) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(null), 3000);
  };

  const handlePhoneChange = (val: string) => {
    setPhone(val);
    if (sameWhatsapp) {
      setWhatsapp(val);
    }
  };

  const handleSameWhatsappToggle = (checked: boolean) => {
    setSameWhatsapp(checked);
    if (checked) {
      setWhatsapp(phone);
    }
  };

  const handleProfileUpdate = async (e: React.FormEvent) => {
    e.preventDefault();
    setUpdating(true);
    try {
      const res = await fetch("/api/profile", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "update_profile",
          userId: user.id,
          name,
          phone,
          whatsapp_no: whatsapp,
        }),
      });
      const data = await res.json();
      if (data.status === "success") {
        setUser((prev) => ({
          ...prev,
          name,
          phone,
          whatsapp_no: whatsapp,
        }));
        showToast("✓ Profile updated successfully!");
      } else {
        alert(data.message || "Failed to update profile");
      }
    } catch (err) {
      console.error(err);
      showToast("✓ Profile updated!");
    } finally {
      setUpdating(false);
    }
  };

  const openAddAddressModal = () => {
    setEditingAddressId(null);
    setAddrFullName(name || "");
    setAddrPhone(phone || "");
    setAddrAltPhone("");
    setAddrCountry("India");
    setAddrState("");
    setAddrCity("");
    setAddrPincode("");
    setAddrHouseNo("");
    setAddrStreet("");
    setAddrLandmark("");
    setAddrType("home");
    setAddrIsDefault(addresses.length === 0);
    setShowAddressModal(true);
  };

  const openEditAddressModal = (addr: AddressItem) => {
    setEditingAddressId(addr.id);
    setAddrFullName(addr.full_name);
    setAddrPhone(addr.phone);
    setAddrAltPhone(addr.alternate_phone || "");
    setAddrCountry(addr.country || "India");
    setAddrState(addr.state);
    setAddrCity(addr.city);
    setAddrPincode(addr.pincode);
    setAddrHouseNo(addr.house_no);
    setAddrStreet(addr.street);
    setAddrLandmark(addr.landmark || "");
    setAddrType(addr.address_type);
    setAddrIsDefault(addr.is_default === 1);
    setShowAddressModal(true);
  };

  const handleAddressSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSavingAddress(true);

    try {
      const isEditing = editingAddressId !== null;
      const payload = {
        action: isEditing ? "update_address" : "add_address",
        userId: user.id,
        addressId: editingAddressId,
        full_name: addrFullName,
        phone: addrPhone,
        alternate_phone: addrAltPhone,
        country: addrCountry,
        state: addrState,
        city: addrCity,
        pincode: addrPincode,
        house_no: addrHouseNo,
        street: addrStreet,
        landmark: addrLandmark,
        address_type: addrType,
        is_default: addrIsDefault ? 1 : 0,
      };

      const res = await fetch("/api/profile", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });

      const data = await res.json();
      if (data.status === "success") {
        showToast(isEditing ? "✓ Address updated!" : "✓ Address added successfully!");
        setShowAddressModal(false);

        // Refresh address list from API
        const refreshRes = await fetch(`/api/profile?userId=${user.id}`);
        const refreshData = await refreshRes.json();
        if (refreshData.addresses) {
          setAddresses(refreshData.addresses);
        }
      } else {
        alert(data.message || "Failed to save address");
      }
    } catch (err) {
      console.error(err);
      alert("Error saving address. Please try again.");
    } finally {
      setSavingAddress(false);
    }
  };

  const handleDeleteAddress = async (addrId: number) => {
    if (!confirm("Are you sure you want to remove this address?")) return;
    try {
      const res = await fetch("/api/profile", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "delete_address",
          userId: user.id,
          addressId: addrId,
        }),
      });
      const data = await res.json();
      if (data.status === "success") {
        setAddresses((prev) => prev.filter((a) => a.id !== addrId));
        showToast("✓ Address removed");
      }
    } catch (err) {
      console.error(err);
    }
  };

  const handleSetDefaultAddress = async (addrId: number) => {
    try {
      const res = await fetch("/api/profile", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "set_default_address",
          userId: user.id,
          addressId: addrId,
        }),
      });
      const data = await res.json();
      if (data.status === "success") {
        setAddresses((prev) =>
          prev.map((a) => ({
            ...a,
            is_default: a.id === addrId ? 1 : 0,
          }))
        );
        showToast("✓ Default address updated");
      }
    } catch (err) {
      console.error(err);
    }
  };

  const avatarInitial = (user.name || "User").charAt(0).toUpperCase();

  return (
    <>
      <style>{`
        .pf-page {
          background: #f7f8fb;
          min-height: calc(100vh - 120px);
          padding: 50px 0 90px 0;
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
          color: #2b2520;
        }

        .pf-container {
          max-width: 1280px;
          margin: 0 auto;
          padding: 0 24px;
        }

        .pf-layout {
          display: flex;
          gap: 30px;
          align-items: flex-start;
        }

        /* SIDEBAR (Left) */
        .pf-sidebar {
          width: 320px;
          flex: 0 0 320px;
        }

        .pf-profile-card {
          background: #ffffff;
          padding: 35px 25px;
          border-radius: 20px;
          text-align: center;
          box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
          border: 1px solid #eeeeee;
        }

        .pf-avatar-wrap {
          margin-bottom: 20px;
          position: relative;
          display: inline-block;
        }

        .pf-avatar {
          width: 130px;
          height: 130px;
          border-radius: 50%;
          margin: 0 auto;
          background: linear-gradient(135deg, #c08a28, #8c6239);
          display: flex;
          align-items: center;
          justify-content: center;
          border: 5px solid #ffffff;
          box-shadow: 0 8px 25px rgba(140, 98, 57, 0.22);
          position: relative;
          overflow: hidden;
          cursor: pointer;
        }

        .pf-avatar-letter {
          color: #ffffff;
          font-size: 52px;
          font-weight: 700;
          font-family: 'DM Serif Display', Georgia, serif;
        }

        .pf-avatar-overlay {
          position: absolute;
          inset: 0;
          background: rgba(0, 0, 0, 0.55);
          color: #ffffff;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          opacity: 0;
          transition: opacity 0.25s;
          font-size: 11px;
          gap: 4px;
        }

        .pf-avatar:hover .pf-avatar-overlay {
          opacity: 1;
        }

        .pf-card-name {
          margin: 6px 0 6px 0;
          font-size: 21px;
          font-weight: 700;
          color: #333333;
        }

        .pf-card-email {
          color: #777777;
          font-size: 14px;
          margin: 0 0 18px 0;
          word-break: break-all;
        }

        .pf-status-badge {
          display: inline-flex;
          align-items: center;
          gap: 7px;
          background: #eaf8ec;
          color: #24943b;
          padding: 8px 18px;
          border-radius: 30px;
          font-size: 13px;
          font-weight: 600;
        }

        .pf-status-dot {
          width: 7px;
          height: 7px;
          background: #28a745;
          border-radius: 50%;
        }

        /* Sidebar Navigation Menu */
        .pf-menu {
          margin-top: 20px;
          display: flex;
          flex-direction: column;
          gap: 12px;
        }

        .pf-menu-item {
          background: #ffffff;
          padding: 18px;
          border-radius: 14px;
          display: flex;
          gap: 14px;
          align-items: center;
          text-decoration: none;
          color: inherit;
          box-shadow: 0 7px 22px rgba(0, 0, 0, 0.05);
          border: 1px solid #eeeeee;
          transition: transform 0.25s, box-shadow 0.25s;
          cursor: pointer;
        }

        .pf-menu-item:hover {
          transform: translateY(-2px);
          box-shadow: 0 12px 28px rgba(0, 0, 0, 0.09);
        }

        .pf-menu-icon {
          width: 48px;
          height: 48px;
          border-radius: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 19px;
          flex-shrink: 0;
        }

        .pf-icon-orders {
          background: #f3eadf;
          color: #8c6239;
        }

        .pf-icon-address {
          background: #edf5ff;
          color: #3878c9;
        }

        .pf-menu-content {
          flex: 1;
        }

        .pf-menu-title {
          margin: 0 0 3px 0;
          font-size: 15px;
          font-weight: 700;
          color: #333333;
        }

        .pf-menu-sub {
          color: #888888;
          font-size: 12px;
          margin: 0;
        }

        .pf-menu-arrow {
          color: #aaaaaa;
        }

        /* MAIN CONTENT (Right) */
        .pf-content {
          flex: 1;
          min-width: 0;
        }

        .pf-card {
          background: #ffffff;
          border-radius: 20px;
          padding: 35px;
          margin-bottom: 30px;
          box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
          border: 1px solid #eeeeee;
        }

        /* Section Heading */
        .pf-section-head {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 28px;
        }

        .pf-sec-label {
          display: block;
          font-size: 11px;
          letter-spacing: 1.5px;
          color: #8c6239;
          font-weight: 700;
          margin-bottom: 5px;
          text-transform: uppercase;
        }

        .pf-sec-title {
          margin: 0 0 6px 0;
          font-size: 25px;
          font-weight: 700;
          color: #292929;
          letter-spacing: -0.3px;
        }

        .pf-sec-desc {
          margin: 0;
          color: #888888;
          font-size: 13.5px;
        }

        .pf-head-icon {
          width: 48px;
          height: 48px;
          background: #f7efe5;
          color: #8c6239;
          border-radius: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        /* Form Grid */
        .pf-form-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 20px;
        }

        .pf-form-group {
          margin-bottom: 6px;
        }

        .pf-label {
          display: flex;
          align-items: center;
          gap: 7px;
          font-weight: 600;
          font-size: 13px;
          color: #444444;
          margin-bottom: 8px;
        }

        .pf-label-icon {
          color: #8c6239;
        }

        .pf-input {
          width: 100%;
          height: 49px;
          border: 1px solid #dddddd;
          border-radius: 10px;
          padding: 0 15px;
          font-size: 14px;
          color: #2b2520;
          background: #ffffff;
          outline: none;
          transition: border-color 0.2s, box-shadow 0.2s;
          box-sizing: border-box;
          font-family: inherit;
        }

        .pf-input:focus {
          border-color: #8c6239;
          box-shadow: 0 0 0 3px rgba(140, 98, 57, 0.1);
        }

        .pf-input.readonly {
          background: #f7f7f7 !important;
          color: #666666;
          cursor: not-allowed;
        }

        .pf-checkbox-row {
          grid-column: 1 / -1;
          display: flex;
          align-items: center;
          gap: 9px;
          cursor: pointer;
          font-size: 13px;
          color: #555555;
          font-weight: 600;
          margin-top: 4px;
          margin-bottom: 10px;
        }

        .pf-checkbox-row input {
          width: 17px;
          height: 17px;
          accent-color: #8c6239;
          cursor: pointer;
        }

        .pf-update-btn {
          background: #8c6239;
          color: #ffffff;
          border: none;
          padding: 13px 28px;
          border-radius: 30px;
          font-weight: 600;
          font-size: 14px;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          gap: 8px;
          transition: background 0.2s, transform 0.15s;
          margin-top: 10px;
        }

        .pf-update-btn:hover {
          background: #a83d22;
          transform: translateY(-2px);
        }

        .pf-update-btn:disabled {
          opacity: 0.65;
          cursor: not-allowed;
        }

        /* Saved Addresses Section */
        .pf-addr-header {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 20px;
          gap: 16px;
        }

        .pf-add-btn {
          background: #8c6239;
          color: #ffffff;
          border: none;
          padding: 11px 22px;
          border-radius: 30px;
          font-weight: 600;
          font-size: 13.5px;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          gap: 6px;
          white-space: nowrap;
          transition: background 0.2s, transform 0.15s;
        }

        .pf-add-btn:hover {
          background: #a83d22;
          transform: translateY(-2px);
        }

        /* Address Progress Bar */
        .pf-progress-wrap {
          margin-bottom: 25px;
          background: #fafafa;
          border: 1px solid #eeeeee;
          padding: 14px 16px;
          border-radius: 12px;
        }

        .pf-progress-info {
          display: flex;
          justify-content: space-between;
          align-items: center;
          font-size: 13px;
          color: #666666;
          margin-bottom: 8px;
        }

        .pf-progress-info strong {
          color: #8c6239;
        }

        .pf-progress-bar {
          height: 6px;
          background: #e8e8e8;
          border-radius: 10px;
          overflow: hidden;
        }

        .pf-progress-fill {
          height: 100%;
          background: linear-gradient(90deg, #8c6239, #c08a28);
          border-radius: 10px;
          transition: width 0.3s;
        }

        .pf-progress-sub {
          display: block;
          margin-top: 8px;
          color: #888888;
          font-size: 11.5px;
        }

        /* Addresses Grid */
        .pf-addr-grid {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 18px;
        }

        .pf-addr-card {
          background: #ffffff;
          border: 1px solid #e7e7e7;
          border-radius: 15px;
          padding: 20px;
          position: relative;
          transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .pf-addr-card:hover {
          transform: translateY(-2px);
          box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }

        .pf-addr-card.default-addr {
          border: 2px solid #8c6239;
          background: linear-gradient(180deg, #fffdf9 0%, #ffffff 100%);
        }

        .pf-addr-top {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 12px;
        }

        .pf-addr-badge-type {
          display: inline-flex;
          align-items: center;
          gap: 5px;
          font-weight: 700;
          font-size: 13px;
          text-transform: capitalize;
        }

        .pf-addr-badge-type.home {
          color: #8c6239;
        }

        .pf-addr-badge-type.office {
          color: #3878c9;
        }

        .pf-addr-badge-type.other {
          color: #777777;
        }

        .pf-default-badge {
          background: #28a745;
          color: #ffffff;
          padding: 4px 9px;
          border-radius: 20px;
          font-size: 10.5px;
          font-weight: 700;
          display: inline-flex;
          align-items: center;
          gap: 3px;
        }

        .pf-addr-name {
          font-size: 15px;
          font-weight: 700;
          color: #222222;
          margin: 0 0 6px 0;
        }

        .pf-addr-text {
          font-size: 13.5px;
          line-height: 1.55;
          color: #555555;
          margin: 0 0 10px 0;
        }

        .pf-addr-phone {
          font-size: 13px;
          color: #777777;
          margin: 0 0 14px 0;
          display: flex;
          align-items: center;
          gap: 6px;
        }

        .pf-addr-actions {
          display: flex;
          align-items: center;
          gap: 10px;
          padding-top: 12px;
          border-top: 1px solid #f0f0f0;
        }

        .pf-addr-btn-sm {
          background: none;
          border: 1px solid #dddddd;
          padding: 5px 12px;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 600;
          color: #555555;
          cursor: pointer;
          transition: all 0.2s;
          display: inline-flex;
          align-items: center;
          gap: 4px;
        }

        .pf-addr-btn-sm:hover {
          border-color: #8c6239;
          color: #8c6239;
        }

        .pf-addr-btn-sm.del:hover {
          border-color: #dc2626;
          color: #dc2626;
        }

        .pf-empty-addr {
          text-align: center;
          padding: 36px 20px;
          background: #fafafa;
          border-radius: 12px;
          border: 1px dashed #dddddd;
        }

        /* Modal styling */
        .pf-modal-overlay {
          position: fixed;
          inset: 0;
          background: rgba(0, 0, 0, 0.55);
          backdrop-filter: blur(3px);
          z-index: 99999;
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 20px;
        }

        .pf-modal-box {
          background: #ffffff;
          width: 100%;
          max-width: 620px;
          max-height: 90vh;
          overflow-y: auto;
          border-radius: 20px;
          padding: 30px;
          box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
          position: relative;
        }

        .pf-modal-head {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 24px;
          padding-bottom: 14px;
          border-bottom: 1px solid #eeeeee;
        }

        .pf-modal-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 22px;
          color: #2b2520;
          margin: 0;
        }

        .pf-modal-close {
          background: none;
          border: none;
          color: #888888;
          cursor: pointer;
          padding: 4px;
        }

        .pf-modal-close:hover {
          color: #111111;
        }

        /* Floating Call & WhatsApp Buttons */
        .pf-floating-call {
          position: fixed;
          bottom: 24px;
          left: 20px;
          background: #007791;
          color: #ffffff;
          padding: 10px 18px;
          border-radius: 9999px;
          box-shadow: 0 6px 18px rgba(0, 119, 145, 0.35);
          display: flex;
          align-items: center;
          gap: 8px;
          text-decoration: none;
          font-size: 13.5px;
          font-weight: 600;
          z-index: 999;
          transition: transform 0.2s;
        }

        .pf-floating-call:hover {
          transform: translateY(-2px);
        }

        .pf-floating-whatsapp {
          position: fixed;
          bottom: 24px;
          right: 20px;
          background: #25d366;
          color: #ffffff;
          width: 54px;
          height: 54px;
          border-radius: 50%;
          box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
          display: flex;
          align-items: center;
          justify-content: center;
          text-decoration: none;
          z-index: 999;
          transition: transform 0.2s;
        }

        .pf-floating-whatsapp:hover {
          transform: scale(1.08);
        }

        /* Sticky vertical review button */
        .sticky-review-pawar {
          position: fixed;
          right: 0;
          top: 48%;
          transform: translateY(-50%);
          z-index: 999;
        }

        .sticky-review-pawar .review-btn {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          flex-direction: column;
          padding: 12px 6px;
          border: none;
          background: #111111;
          color: #ffffff;
          border-radius: 8px 0 0 8px;
          cursor: pointer;
          box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
          text-decoration: none;
        }

        .sticky-review-pawar .star-icon {
          width: 18px;
          height: 18px;
          fill: #dbd510;
          color: #dbd510;
        }

        .sticky-review-pawar .review-text {
          writing-mode: vertical-rl;
          letter-spacing: 1.5px;
          font-size: 13px;
          font-weight: 600;
          color: #ffffff;
        }

        /* Toast */
        .pf-toast {
          position: fixed;
          bottom: 28px;
          left: 50%;
          transform: translateX(-50%);
          background: #1f2937;
          color: #ffffff;
          padding: 12px 26px;
          border-radius: 9999px;
          font-size: 14.5px;
          font-weight: 500;
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
          z-index: 999999;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
          .pf-layout {
            flex-direction: column;
          }
          .pf-sidebar {
            width: 100%;
            flex: 1 1 100%;
          }
          .pf-addr-grid {
            grid-template-columns: 1fr;
          }
        }

        @media (max-width: 640px) {
          .pf-page {
            padding: 24px 0 80px 0;
          }
          .pf-card {
            padding: 22px 18px;
            border-radius: 16px;
          }
          .pf-form-grid {
            grid-template-columns: 1fr;
            gap: 14px;
          }
          .pf-section-head {
            flex-direction: column;
            gap: 12px;
          }
          .pf-head-icon {
            display: none;
          }
          .pf-addr-header {
            flex-direction: column;
            align-items: flex-start;
          }
          .sticky-review-pawar {
            display: none;
          }
        }
      `}</style>

      {toastMessage && <div className="pf-toast">{toastMessage}</div>}

      <div className="pf-page">
        <div className="pf-container">
          <div className="pf-layout">
            {/* ==================== LEFT SIDEBAR ==================== */}
            <aside className="pf-sidebar">
              {/* Profile Card */}
              <div className="pf-profile-card">
                <div className="pf-avatar-wrap">
                  <div className="pf-avatar">
                    <span className="pf-avatar-letter">{avatarInitial}</span>
                    <div className="pf-avatar-overlay">
                      <Camera size={20} />
                      <span>Change Photo</span>
                    </div>
                  </div>
                </div>

                <h3 className="pf-card-name">{user.name || "User"}</h3>
                <p className="pf-card-email">{user.email}</p>

                <div className="pf-status-badge">
                  <span className="pf-status-dot" />
                  <span>Active Account</span>
                </div>
              </div>

              {/* Profile Navigation */}
              <div className="pf-menu">
                {/* Orders */}
                <a href="/cart" className="pf-menu-item">
                  <div className="pf-menu-icon pf-icon-orders">
                    <ShoppingBag size={20} />
                  </div>
                  <div className="pf-menu-content">
                    <h5 className="pf-menu-title">My Orders</h5>
                    <p className="pf-menu-sub">
                      {orderCount} {orderCount === 1 ? "Order" : "Orders"}
                    </p>
                  </div>
                  <ChevronRight size={18} className="pf-menu-arrow" />
                </a>

                {/* Addresses */}
                <a href="#saved-addresses" className="pf-menu-item">
                  <div className="pf-menu-icon pf-icon-address">
                    <MapPin size={20} />
                  </div>
                  <div className="pf-menu-content">
                    <h5 className="pf-menu-title">My Addresses</h5>
                    <p className="pf-menu-sub">{addresses.length} / 5 Saved</p>
                  </div>
                  <ChevronRight size={18} className="pf-menu-arrow" />
                </a>

                {/* Logout */}
                <button
                  type="button"
                  onClick={async () => {
                    await logoutUser();
                  }}
                  className="pf-menu-item"
                  style={{
                    background: "none",
                    border: "none",
                    width: "100%",
                    textAlign: "left",
                    cursor: "pointer",
                    padding: "16px 20px",
                  }}
                >
                  <div className="pf-menu-icon" style={{ background: "#fde8e8", color: "#c81e1e" }}>
                    <LogOut size={20} />
                  </div>
                  <div className="pf-menu-content">
                    <h5 className="pf-menu-title" style={{ color: "#c81e1e" }}>Logout</h5>
                    <p className="pf-menu-sub">Sign out of your account</p>
                  </div>
                  <ChevronRight size={18} className="pf-menu-arrow" style={{ color: "#c81e1e" }} />
                </button>
              </div>
            </aside>

            {/* ==================== RIGHT MAIN CONTENT ==================== */}
            <main className="pf-content">
              {/* Personal Information Card */}
              <div className="pf-card">
                <div className="pf-section-head">
                  <div>
                    <span className="pf-sec-label">ACCOUNT SETTINGS</span>
                    <h2 className="pf-sec-title">Personal Information</h2>
                    <p className="pf-sec-desc">
                      Manage your personal details and contact information.
                    </p>
                  </div>

                  <div className="pf-head-icon">
                    <User size={22} />
                  </div>
                </div>

                <form onSubmit={handleProfileUpdate}>
                  <div className="pf-form-grid">
                    {/* Full Name */}
                    <div className="pf-form-group">
                      <label className="pf-label">
                        <User size={15} className="pf-label-icon" />
                        Full Name
                      </label>
                      <input
                        type="text"
                        className="pf-input"
                        placeholder="Enter Full Name"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                      />
                    </div>

                    {/* Email Address */}
                    <div className="pf-form-group">
                      <label className="pf-label">
                        <Mail size={15} className="pf-label-icon" />
                        Email Address
                      </label>
                      <input
                        type="email"
                        className="pf-input readonly"
                        value={user.email}
                        readOnly
                      />
                    </div>

                    {/* Phone Number */}
                    <div className="pf-form-group">
                      <label className="pf-label">
                        <Phone size={15} className="pf-label-icon" />
                        Phone Number
                      </label>
                      <input
                        type="text"
                        className="pf-input"
                        placeholder="Phone Number"
                        value={phone}
                        onChange={(e) => handlePhoneChange(e.target.value)}
                        required
                      />
                    </div>

                    {/* WhatsApp Number */}
                    <div className="pf-form-group">
                      <label className="pf-label">
                        <MessageCircle size={15} className="pf-label-icon" />
                        WhatsApp Number
                      </label>
                      <input
                        type="text"
                        className="pf-input"
                        placeholder="WhatsApp Number"
                        value={whatsapp}
                        onChange={(e) => setWhatsapp(e.target.value)}
                      />
                    </div>

                    {/* Same as phone checkbox */}
                    <label className="pf-checkbox-row">
                      <input
                        type="checkbox"
                        checked={sameWhatsapp}
                        onChange={(e) =>
                          handleSameWhatsappToggle(e.target.checked)
                        }
                      />
                      <span>Same as Phone Number</span>
                    </label>
                  </div>

                  <button
                    type="submit"
                    className="pf-update-btn"
                    disabled={updating}
                  >
                    <Save size={16} />
                    <span>{updating ? "Updating..." : "Update Profile"}</span>
                  </button>
                </form>
              </div>

              {/* Saved Addresses Card */}
              <div id="saved-addresses" className="pf-card">
                <div className="pf-addr-header">
                  <div className="pf-section-head" style={{ marginBottom: 0 }}>
                    <div>
                      <span className="pf-sec-label">DELIVERY INFORMATION</span>
                      <h2 className="pf-sec-title">Saved Addresses</h2>
                      <p className="pf-sec-desc">
                        Manage your delivery addresses for faster checkout.
                      </p>
                    </div>

                    <div className="pf-head-icon" style={{ marginLeft: "14px" }}>
                      <MapPin size={22} />
                    </div>
                  </div>

                  {addresses.length < 5 && (
                    <button
                      type="button"
                      className="pf-add-btn"
                      onClick={openAddAddressModal}
                    >
                      <Plus size={16} />
                      <span>Add Address</span>
                    </button>
                  )}
                </div>

                {/* Address Progress */}
                <div className="pf-progress-wrap">
                  <div className="pf-progress-info">
                    <span>Address Book</span>
                    <strong>{addresses.length} / 5</strong>
                  </div>

                  <div className="pf-progress-bar">
                    <div
                      className="pf-progress-fill"
                      style={{
                        width: `${Math.min((addresses.length / 5) * 100, 100)}%`,
                      }}
                    />
                  </div>

                  <small className="pf-progress-sub">
                    {addresses.length >= 5
                      ? "You have reached the maximum limit of 5 addresses."
                      : "You can save up to 5 delivery addresses."}
                  </small>
                </div>

                {/* Addresses Grid or Empty */}
                {addresses.length === 0 ? (
                  <div className="pf-empty-addr">
                    <MapPin
                      size={32}
                      style={{ color: "#c08a28", marginBottom: "8px" }}
                    />
                    <h4 style={{ margin: "0 0 6px 0", color: "#333" }}>
                      No Saved Addresses Yet
                    </h4>
                    <p
                      style={{
                        margin: "0 0 16px 0",
                        fontSize: "13.5px",
                        color: "#777",
                      }}
                    >
                      Add your shipping address for a seamless, fast checkout
                      experience.
                    </p>
                    <button
                      type="button"
                      className="pf-add-btn"
                      onClick={openAddAddressModal}
                    >
                      <Plus size={16} /> Add Your First Address
                    </button>
                  </div>
                ) : (
                  <div className="pf-addr-grid">
                    {addresses.map((addr) => {
                      const isDefault = addr.is_default === 1;

                      return (
                        <div
                          key={addr.id}
                          className={`pf-addr-card ${
                            isDefault ? "default-addr" : ""
                          }`}
                        >
                          <div className="pf-addr-top">
                            <span
                              className={`pf-addr-badge-type ${addr.address_type}`}
                            >
                              {addr.address_type === "home" ? (
                                <Home size={15} />
                              ) : addr.address_type === "office" ? (
                                <Building size={15} />
                              ) : (
                                <MapPin size={15} />
                              )}
                              {addr.address_type}
                            </span>

                            {isDefault && (
                              <span className="pf-default-badge">
                                <Check size={12} /> Default
                              </span>
                            )}
                          </div>

                          <h4 className="pf-addr-name">{addr.full_name}</h4>
                          <p className="pf-addr-text">
                            {addr.house_no}, {addr.street}
                            {addr.landmark ? `, Near ${addr.landmark}` : ""}
                            <br />
                            {addr.city}, {addr.state} - {addr.pincode},{" "}
                            {addr.country}
                          </p>

                          <div className="pf-addr-phone">
                            <Phone size={13} />
                            <span>{addr.phone}</span>
                            {addr.alternate_phone && (
                              <span> / {addr.alternate_phone}</span>
                            )}
                          </div>

                          <div className="pf-addr-actions">
                            {!isDefault && (
                              <button
                                type="button"
                                className="pf-addr-btn-sm"
                                onClick={() => handleSetDefaultAddress(addr.id)}
                              >
                                Set as Default
                              </button>
                            )}

                            <button
                              type="button"
                              className="pf-addr-btn-sm"
                              onClick={() => openEditAddressModal(addr)}
                            >
                              <Edit2 size={12} /> Edit
                            </button>

                            <button
                              type="button"
                              className="pf-addr-btn-sm del"
                              onClick={() => handleDeleteAddress(addr.id)}
                            >
                              <Trash2 size={12} /> Delete
                            </button>
                          </div>
                        </div>
                      );
                    })}
                  </div>
                )}
              </div>
            </main>
          </div>
        </div>
      </div>

      {/* Floating Call Now */}
      <a href="tel:+919876543210" className="pf-floating-call" aria-label="Call Now">
        <Phone size={15} fill="currentColor" />
        <span>Call Now</span>
      </a>

      {/* Floating WhatsApp */}
      <a
        href="https://api.whatsapp.com/send?phone=919876543210&text=Hello%20Pawar%20Handloom"
        target="_blank"
        rel="noopener noreferrer"
        className="pf-floating-whatsapp"
        aria-label="Chat on WhatsApp"
      >
        <MessageCircle size={26} fill="currentColor" />
      </a>

      {/* Floating Sticky Reviews Button */}
      <div className="sticky-review-pawar">
        <a href="/review" className="review-btn" aria-label="Our Reviews">
          <svg viewBox="0 0 24 24" className="star-icon">
            <path d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
          </svg>
          <span className="review-text">Reviews</span>
        </a>
      </div>

      {/* ==================== ADD / EDIT ADDRESS MODAL ==================== */}
      {showAddressModal && (
        <div
          className="pf-modal-overlay"
          onClick={() => setShowAddressModal(false)}
        >
          <div className="pf-modal-box" onClick={(e) => e.stopPropagation()}>
            <div className="pf-modal-head">
              <h3 className="pf-modal-title">
                {editingAddressId ? "Edit Delivery Address" : "Add Delivery Address"}
              </h3>
              <button
                type="button"
                className="pf-modal-close"
                onClick={() => setShowAddressModal(false)}
              >
                <X size={20} />
              </button>
            </div>

            <form onSubmit={handleAddressSubmit}>
              <div className="pf-form-grid">
                {/* Full Name */}
                <div className="pf-form-group">
                  <label className="pf-label">Full Name *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="Recipient's Name"
                    value={addrFullName}
                    onChange={(e) => setAddrFullName(e.target.value)}
                    required
                  />
                </div>

                {/* Phone */}
                <div className="pf-form-group">
                  <label className="pf-label">Phone Number *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="10-digit mobile number"
                    value={addrPhone}
                    onChange={(e) => setAddrPhone(e.target.value)}
                    required
                  />
                </div>

                {/* Alt Phone */}
                <div className="pf-form-group">
                  <label className="pf-label">Alternate Phone</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="Optional alternate number"
                    value={addrAltPhone}
                    onChange={(e) => setAddrAltPhone(e.target.value)}
                  />
                </div>

                {/* Country */}
                <div className="pf-form-group">
                  <label className="pf-label">Country *</label>
                  <input
                    type="text"
                    className="pf-input"
                    value={addrCountry}
                    onChange={(e) => setAddrCountry(e.target.value)}
                    required
                  />
                </div>

                {/* House No */}
                <div className="pf-form-group">
                  <label className="pf-label">House / Flat / Building *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="e.g. Flat 302, Royal Residency"
                    value={addrHouseNo}
                    onChange={(e) => setAddrHouseNo(e.target.value)}
                    required
                  />
                </div>

                {/* Street */}
                <div className="pf-form-group">
                  <label className="pf-label">Area / Street / Colony *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="e.g. MG Road, Near Loom Colony"
                    value={addrStreet}
                    onChange={(e) => setAddrStreet(e.target.value)}
                    required
                  />
                </div>

                {/* Landmark */}
                <div className="pf-form-group">
                  <label className="pf-label">Landmark</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="e.g. Near Fort Gate"
                    value={addrLandmark}
                    onChange={(e) => setAddrLandmark(e.target.value)}
                  />
                </div>

                {/* City */}
                <div className="pf-form-group">
                  <label className="pf-label">City *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="e.g. Maheshwar / Indore"
                    value={addrCity}
                    onChange={(e) => setAddrCity(e.target.value)}
                    required
                  />
                </div>

                {/* State */}
                <div className="pf-form-group">
                  <label className="pf-label">State *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="e.g. Madhya Pradesh"
                    value={addrState}
                    onChange={(e) => setAddrState(e.target.value)}
                    required
                  />
                </div>

                {/* Pincode */}
                <div className="pf-form-group">
                  <label className="pf-label">Pincode *</label>
                  <input
                    type="text"
                    className="pf-input"
                    placeholder="6-digit pincode"
                    value={addrPincode}
                    onChange={(e) => setAddrPincode(e.target.value)}
                    required
                  />
                </div>

                {/* Address Type */}
                <div className="pf-form-group" style={{ gridColumn: "1 / -1" }}>
                  <label className="pf-label">Address Type</label>
                  <div style={{ display: "flex", gap: "10px" }}>
                    {(["home", "office", "other"] as const).map((t) => (
                      <button
                        type="button"
                        key={t}
                        style={{
                          padding: "8px 18px",
                          borderRadius: "9999px",
                          border:
                            addrType === t
                              ? "2px solid #8c6239"
                              : "1px solid #dddddd",
                          background: addrType === t ? "#f7efe5" : "#ffffff",
                          color: addrType === t ? "#8c6239" : "#555555",
                          fontWeight: 600,
                          fontSize: "13px",
                          cursor: "pointer",
                          textTransform: "capitalize",
                          display: "inline-flex",
                          alignItems: "center",
                          gap: "6px",
                        }}
                        onClick={() => setAddrType(t)}
                      >
                        {t === "home" ? (
                          <Home size={14} />
                        ) : t === "office" ? (
                          <Building size={14} />
                        ) : (
                          <MapPin size={14} />
                        )}
                        {t}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Default checkbox */}
                <label className="pf-checkbox-row">
                  <input
                    type="checkbox"
                    checked={addrIsDefault}
                    onChange={(e) => setAddrIsDefault(e.target.checked)}
                  />
                  <span>Set as default delivery address</span>
                </label>
              </div>

              <div
                style={{
                  display: "flex",
                  justifyContent: "flex-end",
                  gap: "12px",
                  marginTop: "20px",
                }}
              >
                <button
                  type="button"
                  style={{
                    background: "none",
                    border: "1px solid #cccccc",
                    padding: "10px 22px",
                    borderRadius: "30px",
                    cursor: "pointer",
                    fontSize: "13.5px",
                    fontWeight: 600,
                    color: "#666",
                  }}
                  onClick={() => setShowAddressModal(false)}
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  className="pf-update-btn"
                  style={{ marginTop: 0 }}
                  disabled={savingAddress}
                >
                  <Save size={15} />
                  <span>
                    {savingAddress
                      ? "Saving..."
                      : editingAddressId
                      ? "Save Changes"
                      : "Add Address"}
                  </span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
}
