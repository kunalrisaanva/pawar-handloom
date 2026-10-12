"use client";

import { useState, useMemo } from "react";
import {
  ArrowLeft,
  Search,
  SlidersHorizontal,
  ArrowUpDown,
  ShoppingBag,
  Heart,
  Check,
  Sparkles,
  Phone,
  MessageCircle,
  X,
  Filter,
  Truck,
  ShieldCheck,
  RefreshCw,
  ChevronDown,
} from "lucide-react";

interface ProductItem {
  id: number;
  product_name: string;
  category: number;
  category_name?: string;
  actual_price: number | string;
  actual_price_customer?: number | string;
  offer_price: number | string;
  cover_image: string;
  fabric_type?: string;
  material?: string;
  other_feature?: string;
  description?: string;
  status: number;
}

interface NewArrivalsClientProps {
  initialProducts: ProductItem[];
  categoryInfo: {
    id?: number;
    category_name: string;
    category_description?: string;
  };
}

export default function NewArrivalsClient({
  initialProducts = [],
  categoryInfo,
}: NewArrivalsClientProps) {
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedCategory, setSelectedCategory] = useState("all");
  const [selectedPriceRange, setSelectedPriceRange] = useState("all");
  const [sortBy, setSortBy] = useState("latest");
  const [wishlist, setWishlist] = useState<Record<number, boolean>>({});
  const [addingCartId, setAddingCartId] = useState<number | null>(null);
  const [toastMessage, setToastMessage] = useState<string | null>(null);
  const [showMobileFilters, setShowMobileFilters] = useState(false);

  const showToast = (msg: string) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(null), 3000);
  };

  const toggleWishlist = (id: number, e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    setWishlist((prev) => {
      const next = !prev[id];
      if (next) {
        showToast("♥ Added to Wishlist");
      }
      return { ...prev, [id]: next };
    });
  };

  const formatINR = (val: number) => {
    return val.toLocaleString("en-IN", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  };

  const calculateFinalPrice = (product: ProductItem) => {
    const actual = Number(
      product.actual_price_customer || product.actual_price || 0
    );
    const rawOffer = Number(product.offer_price || 0);

    let finalPrice = actual;
    let discountPercent = 0;

    if (rawOffer > 0 && rawOffer <= 100) {
      discountPercent = Math.round(rawOffer);
      finalPrice = Math.max(0, actual - (actual * discountPercent) / 100);
    } else if (rawOffer > 100) {
      finalPrice = rawOffer;
      if (actual > finalPrice) {
        discountPercent = Math.round(((actual - finalPrice) / actual) * 100);
      }
    }

    return { actual, finalPrice, discountPercent };
  };

  const handleQuickAddToCart = async (product: ProductItem, e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    setAddingCartId(product.id);

    try {
      const { finalPrice } = calculateFinalPrice(product);
      const imageUrl = product.cover_image
        ? "http://localhost:8080/" + product.cover_image
        : "";

      const formData = new URLSearchParams();
      formData.append("id", product.id.toString());
      formData.append("product_name", product.product_name);
      formData.append("offer_price", finalPrice.toString());
      formData.append("qty", "1");
      formData.append("image", imageUrl);
      formData.append("color", "");

      const res = await fetch("http://localhost:8080/cart/add", {
        method: "POST",
        credentials: "include",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: formData.toString(),
      });

      const data = await res.json().catch(() => ({}));
      if (data.status === "success" || res.ok) {
        window.dispatchEvent(new Event("cart-updated"));
        showToast("✓ Added to cart successfully!");
      } else {
        alert(data.message || "Failed to add to cart");
      }
    } catch (err) {
      console.error("Cart error:", err);
      showToast("✓ Added to cart!");
    } finally {
      setAddingCartId(null);
    }
  };

  // Distinct categories available in products
  const categoryOptions = useMemo(() => {
    const cats = new Set<string>();
    initialProducts.forEach((p) => {
      if (p.category_name && p.category_name.trim()) {
        cats.add(p.category_name.trim());
      }
    });
    return Array.from(cats);
  }, [initialProducts]);

  // Filtered and Sorted products
  const filteredProducts = useMemo(() => {
    let result = [...initialProducts];

    // Search filter
    if (searchTerm.trim()) {
      const query = searchTerm.toLowerCase().trim();
      result = result.filter(
        (p) =>
          p.product_name.toLowerCase().includes(query) ||
          (p.category_name && p.category_name.toLowerCase().includes(query)) ||
          (p.fabric_type && p.fabric_type.toLowerCase().includes(query))
      );
    }

    // Category filter
    if (selectedCategory !== "all") {
      result = result.filter(
        (p) =>
          p.category_name &&
          p.category_name.trim().toLowerCase() === selectedCategory.toLowerCase()
      );
    }

    // Price range filter
    if (selectedPriceRange !== "all") {
      result = result.filter((p) => {
        const { finalPrice } = calculateFinalPrice(p);
        if (selectedPriceRange === "under2500") return finalPrice < 2500;
        if (selectedPriceRange === "2500-3500")
          return finalPrice >= 2500 && finalPrice <= 3500;
        if (selectedPriceRange === "3500-5000")
          return finalPrice > 3500 && finalPrice <= 5000;
        if (selectedPriceRange === "above5000") return finalPrice > 5000;
        return true;
      });
    }

    // Sort
    result.sort((a, b) => {
      const priceA = calculateFinalPrice(a).finalPrice;
      const priceB = calculateFinalPrice(b).finalPrice;
      const discA = calculateFinalPrice(a).discountPercent;
      const discB = calculateFinalPrice(b).discountPercent;

      if (sortBy === "price_asc") return priceA - priceB;
      if (sortBy === "price_desc") return priceB - priceA;
      if (sortBy === "discount") return discB - discA;
      if (sortBy === "name_asc")
        return a.product_name.localeCompare(b.product_name);
      // Default: latest (category 6 first, then id desc)
      const aIsCat6 = a.category === 6 ? 1 : 0;
      const bIsCat6 = b.category === 6 ? 1 : 0;
      if (aIsCat6 !== bIsCat6) return bIsCat6 - aIsCat6;
      return b.id - a.id;
    });

    return result;
  }, [initialProducts, searchTerm, selectedCategory, selectedPriceRange, sortBy]);

  const clearFilters = () => {
    setSearchTerm("");
    setSelectedCategory("all");
    setSelectedPriceRange("all");
    setSortBy("latest");
  };

  const isFiltered =
    searchTerm.trim() !== "" ||
    selectedCategory !== "all" ||
    selectedPriceRange !== "all" ||
    sortBy !== "latest";

  return (
    <>
      <style>{`
        .na-wrapper {
          background-color: #faf7f2;
          min-height: 100vh;
          padding-bottom: 90px;
          color: #2b2520;
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .na-container {
          max-width: 1360px;
          margin: 0 auto;
          padding: 0 24px;
        }

        /* Hero Banner */
        .na-hero {
          background: linear-gradient(135deg, #fdfbf7 0%, #f4ede1 100%);
          border-bottom: 1px solid #ebdccb;
          padding: 40px 0 36px 0;
          margin-bottom: 32px;
          position: relative;
          overflow: hidden;
        }

        .na-hero::before {
          content: "";
          position: absolute;
          top: -60px;
          right: -60px;
          width: 240px;
          height: 240px;
          background: radial-gradient(circle, rgba(168, 61, 34, 0.08) 0%, transparent 70%);
          border-radius: 50%;
          pointer-events: none;
        }

        .na-breadcrumb {
          display: flex;
          align-items: center;
          gap: 8px;
          font-size: 13.5px;
          color: #7d7268;
          margin-bottom: 16px;
        }

        .na-breadcrumb a {
          color: #7d7268;
          text-decoration: none;
          transition: color 0.2s;
          display: inline-flex;
          align-items: center;
          gap: 4px;
        }

        .na-breadcrumb a:hover {
          color: #a83d22;
        }

        .na-breadcrumb-sep {
          color: #b5a89b;
        }

        .na-breadcrumb-active {
          color: #a83d22;
          font-weight: 600;
        }

        .na-hero-title-row {
          display: flex;
          align-items: flex-end;
          justify-content: space-between;
          flex-wrap: wrap;
          gap: 16px;
        }

        .na-hero-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 38px;
          color: #2b2520;
          margin: 0 0 8px 0;
          line-height: 1.15;
          letter-spacing: -0.3px;
        }

        .na-hero-badge {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          background: #a83d22;
          color: #ffffff;
          padding: 4px 12px;
          border-radius: 9999px;
          font-size: 12px;
          font-weight: 600;
          letter-spacing: 0.5px;
          text-transform: uppercase;
          margin-bottom: 10px;
        }

        .na-hero-subtitle {
          font-size: 15px;
          color: #6a5e52;
          max-width: 650px;
          margin: 0;
          line-height: 1.55;
        }

        .na-trust-strip {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 14px;
          margin-top: 28px;
          padding-top: 24px;
          border-top: 1px dashed #dfd1be;
        }

        .na-trust-item {
          display: flex;
          align-items: center;
          gap: 10px;
          font-size: 13px;
          font-weight: 500;
          color: #4a3e33;
        }

        .na-trust-icon {
          color: #a83d22;
          flex-shrink: 0;
        }

        /* Filter Controls Toolbar */
        .na-toolbar-card {
          background: #ffffff;
          border-radius: 16px;
          border: 1px solid #ede3c9;
          padding: 20px 24px;
          margin-bottom: 30px;
          box-shadow: 0 3px 14px rgba(80, 50, 30, 0.04);
        }

        .na-toolbar-top {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 16px;
          flex-wrap: wrap;
        }

        .na-search-box {
          position: relative;
          flex: 1;
          min-width: 260px;
          max-width: 420px;
        }

        .na-search-input {
          width: 100%;
          padding: 11px 16px 11px 40px;
          border-radius: 9999px;
          border: 1.5px solid #dfd3c0;
          background: #faf7f2;
          font-size: 14px;
          color: #2b2520;
          outline: none;
          transition: border-color 0.2s, background 0.2s;
          box-sizing: border-box;
        }

        .na-search-input:focus {
          border-color: #a83d22;
          background: #ffffff;
        }

        .na-search-icon {
          position: absolute;
          left: 14px;
          top: 50%;
          transform: translateY(-50%);
          color: #8c7e70;
          pointer-events: none;
        }

        .na-search-clear {
          position: absolute;
          right: 12px;
          top: 50%;
          transform: translateY(-50%);
          background: none;
          border: none;
          color: #8c7e70;
          cursor: pointer;
          padding: 2px;
        }

        .na-toolbar-actions {
          display: flex;
          align-items: center;
          gap: 14px;
        }

        .na-sort-wrap {
          display: flex;
          align-items: center;
          gap: 8px;
        }

        .na-sort-label {
          font-size: 13.5px;
          font-weight: 500;
          color: #6b5e52;
          white-space: nowrap;
        }

        .na-select {
          padding: 9px 34px 9px 14px;
          border-radius: 9999px;
          border: 1.5px solid #dfd3c0;
          background: #ffffff;
          font-size: 13.5px;
          color: #2b2520;
          font-weight: 500;
          outline: none;
          cursor: pointer;
          appearance: none;
          background-image: url("data:image/svg2+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b5e52' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
          background-repeat: no-repeat;
          background-position: right 12px center;
          transition: border-color 0.2s;
        }

        .na-select:focus {
          border-color: #a83d22;
        }

        /* Filter Chips row */
        .na-chips-row {
          display: flex;
          align-items: center;
          gap: 10px;
          margin-top: 18px;
          padding-top: 16px;
          border-top: 1px solid #f2e9dc;
          overflow-x: auto;
          scrollbar-width: none;
        }

        .na-chips-row::-webkit-scrollbar {
          display: none;
        }

        .na-chip-btn {
          background: #f7f3ec;
          border: 1px solid #e3d7c5;
          color: #55493d;
          font-size: 13px;
          font-weight: 500;
          padding: 7px 16px;
          border-radius: 9999px;
          cursor: pointer;
          white-space: nowrap;
          transition: all 0.2s;
        }

        .na-chip-btn:hover {
          border-color: #a83d22;
          color: #a83d22;
          background: #ffffff;
        }

        .na-chip-btn.active {
          background: #a83d22;
          border-color: #a83d22;
          color: #ffffff;
          font-weight: 600;
          box-shadow: 0 2px 8px rgba(168, 61, 34, 0.25);
        }

        /* Results summary bar */
        .na-summary-bar {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 22px;
          font-size: 14px;
          color: #6a5e52;
        }

        .na-results-count {
          font-weight: 600;
          color: #2b2520;
        }

        .na-clear-btn {
          background: none;
          border: none;
          color: #a83d22;
          font-weight: 600;
          cursor: pointer;
          font-size: 13.5px;
          padding: 4px 8px;
          border-radius: 6px;
          display: inline-flex;
          align-items: center;
          gap: 4px;
        }

        .na-clear-btn:hover {
          text-decoration: underline;
        }

        /* Product Grid */
        .na-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 24px;
        }

        .na-card {
          background: #ffffff;
          border-radius: 16px;
          border: 1px solid #ede3c9;
          overflow: hidden;
          display: flex;
          flex-direction: column;
          position: relative;
          text-decoration: none;
          color: inherit;
          transition: transform 0.25s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .na-card:hover {
          transform: translateY(-6px);
          box-shadow: 0 14px 30px rgba(80, 50, 30, 0.09);
        }

        .na-card-media {
          aspect-ratio: 3/4;
          background: #fbf9f5;
          position: relative;
          overflow: hidden;
        }

        .na-card-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
          transition: transform 0.45s ease;
        }

        .na-card:hover .na-card-img {
          transform: scale(1.05);
        }

        /* Badges */
        .na-badge-new {
          position: absolute;
          top: 12px;
          left: 12px;
          background: #a83d22;
          color: #ffffff;
          font-size: 11px;
          font-weight: 700;
          letter-spacing: 0.5px;
          padding: 4px 10px;
          border-radius: 9999px;
          text-transform: uppercase;
          z-index: 2;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .na-badge-off {
          position: absolute;
          bottom: 12px;
          left: 12px;
          background: rgba(17, 24, 39, 0.88);
          backdrop-filter: blur(4px);
          color: #facc15;
          font-size: 11px;
          font-weight: 700;
          padding: 3px 8px;
          border-radius: 6px;
          z-index: 2;
        }

        .na-wishlist-btn {
          position: absolute;
          top: 12px;
          right: 12px;
          width: 36px;
          height: 36px;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.92);
          backdrop-filter: blur(4px);
          border: none;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          color: #716253;
          z-index: 3;
          transition: transform 0.2s, background 0.2s, color 0.2s;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .na-wishlist-btn:hover {
          transform: scale(1.1);
          background: #ffffff;
          color: #a83d22;
        }

        .na-wishlist-btn.active {
          color: #dc2626;
        }

        /* Card Content */
        .na-card-content {
          padding: 18px 16px 18px;
          display: flex;
          flex-direction: column;
          flex: 1;
        }

        .na-card-cat {
          font-size: 11.5px;
          font-weight: 600;
          text-transform: uppercase;
          letter-spacing: 0.7px;
          color: #9c8976;
          margin-bottom: 6px;
        }

        .na-card-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 17px;
          color: #2b2520;
          margin: 0 0 10px 0;
          line-height: 1.35;
          height: 46px;
          overflow: hidden;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
        }

        .na-card-price-block {
          margin-top: auto;
          display: flex;
          align-items: baseline;
          gap: 8px;
          flex-wrap: wrap;
          padding-bottom: 14px;
        }

        .na-price-final {
          font-size: 18px;
          font-weight: 700;
          color: #a83d22;
        }

        .na-price-mrp {
          font-size: 13.5px;
          color: #8c7e70;
          text-decoration: line-through;
        }

        .na-price-disc {
          font-size: 11.5px;
          font-weight: 700;
          color: #16a34a;
        }

        /* Quick Add Button */
        .na-quick-add-btn {
          width: 100%;
          background: #fbf9f5;
          border: 1.5px solid #dcd0bd;
          color: #2b2520;
          padding: 10px 14px;
          border-radius: 9999px;
          font-size: 13.5px;
          font-weight: 600;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 7px;
          transition: all 0.2s;
        }

        .na-quick-add-btn:hover {
          background: #a83d22;
          border-color: #a83d22;
          color: #ffffff;
        }

        .na-quick-add-btn:disabled {
          opacity: 0.6;
          cursor: not-allowed;
        }

        /* Empty State */
        .na-empty-box {
          background: #ffffff;
          border-radius: 18px;
          border: 1px dashed #dcd0bd;
          padding: 60px 24px;
          text-align: center;
          margin-top: 20px;
        }

        .na-empty-icon {
          width: 56px;
          height: 56px;
          border-radius: 50%;
          background: #f5ede1;
          color: #a83d22;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          margin-bottom: 18px;
        }

        .na-empty-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 24px;
          color: #2b2520;
          margin: 0 0 8px 0;
        }

        .na-empty-desc {
          font-size: 14.5px;
          color: #6a5e52;
          margin: 0 0 20px 0;
        }

        .na-empty-reset-btn {
          background: #a83d22;
          color: #ffffff;
          border: none;
          padding: 11px 26px;
          border-radius: 9999px;
          font-size: 14px;
          font-weight: 600;
          cursor: pointer;
          transition: background 0.2s;
        }

        .na-empty-reset-btn:hover {
          background: #8b321a;
        }

        /* Toast */
        .na-toast {
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
          z-index: 99999;
          animation: naSlideUp 0.25s ease-out;
        }

        @keyframes naSlideUp {
          from { opacity: 0; transform: translate(-50%, 14px); }
          to { opacity: 1; transform: translate(-50%, 0); }
        }

        /* Floating Call and WhatsApp */
        .na-floating-call {
          position: fixed;
          bottom: 24px;
          left: 20px;
          background: #a83d22;
          color: #ffffff;
          padding: 10px 18px;
          border-radius: 9999px;
          box-shadow: 0 6px 18px rgba(168, 61, 34, 0.35);
          display: flex;
          align-items: center;
          gap: 8px;
          text-decoration: none;
          font-size: 13.5px;
          font-weight: 600;
          z-index: 999;
          transition: transform 0.2s, background 0.2s;
        }

        .na-floating-call:hover {
          background: #8b321a;
          transform: translateY(-2px);
        }

        .na-floating-whatsapp {
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
          transition: transform 0.2s, background 0.2s;
        }

        .na-floating-whatsapp:hover {
          transform: scale(1.08);
          background: #20ba5a;
        }

        /* Responsive Breakpoints */
        /* 1. Tablet (max-width: 1024px) */
        @media (max-width: 1024px) {
          .na-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
          }
          .na-trust-strip {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
          }
        }

        /* 2. Mobile (max-width: 768px) */
        @media (max-width: 768px) {
          .na-hero {
            padding: 26px 0 24px 0;
            margin-bottom: 20px;
          }
          .na-hero-title {
            font-size: 28px;
          }
          .na-hero-subtitle {
            font-size: 13.5px;
          }
          .na-trust-strip {
            display: none;
          }
          .na-toolbar-card {
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 14px;
          }
          .na-toolbar-top {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
          }
          .na-search-box {
            max-width: 100%;
          }
          .na-toolbar-actions {
            justify-content: space-between;
          }
          .na-chips-row {
            margin-top: 12px;
            padding-top: 12px;
            gap: 8px;
          }
          .na-chip-btn {
            font-size: 12px;
            padding: 6px 12px;
          }
          /* 2 Columns on Mobile */
          .na-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
          }
          .na-card {
            border-radius: 12px;
          }
          .na-card-content {
            padding: 12px 10px;
          }
          .na-card-title {
            font-size: 13.5px;
            height: 38px;
            margin-bottom: 6px;
          }
          .na-card-cat {
            font-size: 10px;
            margin-bottom: 4px;
          }
          .na-price-final {
            font-size: 15px;
          }
          .na-price-mrp {
            font-size: 12px;
          }
          .na-price-disc {
            font-size: 10.5px;
          }
          .na-quick-add-btn {
            padding: 7px 10px;
            font-size: 12px;
          }
          .na-badge-new {
            font-size: 9.5px;
            padding: 3px 8px;
            top: 8px;
            left: 8px;
          }
          .na-wishlist-btn {
            width: 30px;
            height: 30px;
            top: 8px;
            right: 8px;
          }
          .na-floating-call {
            bottom: 16px;
            left: 14px;
            padding: 8px 14px;
            font-size: 12px;
          }
          .na-floating-whatsapp {
            bottom: 16px;
            right: 14px;
            width: 46px;
            height: 46px;
          }
        }

        /* 3. Tiny Mobile (max-width: 380px) */
        @media (max-width: 380px) {
          .na-container {
            padding: 0 12px;
          }
          .na-grid {
            gap: 8px;
          }
          .na-card-content {
            padding: 10px 8px;
          }
          .na-card-title {
            font-size: 12.5px;
          }
          .na-price-final {
            font-size: 14px;
          }
        }
      `}</style>

      {toastMessage && <div className="na-toast">{toastMessage}</div>}

      <div className="na-wrapper">
        {/* Hero Section */}
        <div className="na-hero">
          <div className="na-container">
            {/* Breadcrumb */}
            <div className="na-breadcrumb">
              <a href="/">
                <ArrowLeft size={14} /> Home
              </a>
              <span className="na-breadcrumb-sep">/</span>
              <span className="na-breadcrumb-active">New Arrivals</span>
            </div>

            {/* Title & Badge */}
            <div className="na-hero-title-row">
              <div>
                <span className="na-hero-badge">
                  <Sparkles size={13} /> Fresh Looms 2026
                </span>
                <h1 className="na-hero-title">New Arrivals</h1>
                <p className="na-hero-subtitle">
                  {categoryInfo.category_description ||
                    "Explore our newest handwoven sarees, dupattas, and suits freshly crafted by master artisans in Maheshwar."}
                </p>
              </div>
            </div>

            {/* Trust highlights */}
            <div className="na-trust-strip">
              <div className="na-trust-item">
                <Sparkles size={18} className="na-trust-icon" />
                <span>100% Authentic Handloom</span>
              </div>
              <div className="na-trust-item">
                <Truck size={18} className="na-trust-icon" />
                <span>Free Shipping Across India</span>
              </div>
              <div className="na-trust-item">
                <ShieldCheck size={18} className="na-trust-icon" />
                <span>Direct Artisan Pricing</span>
              </div>
              <div className="na-trust-item">
                <RefreshCw size={18} className="na-trust-icon" />
                <span>7 Days Easy Exchange</span>
              </div>
            </div>
          </div>
        </div>

        {/* Main Content Area */}
        <div className="na-container">
          {/* Toolbar Card: Search, Sort, Category Chips */}
          <div className="na-toolbar-card">
            <div className="na-toolbar-top">
              {/* Search Box */}
              <div className="na-search-box">
                <Search size={16} className="na-search-icon" />
                <input
                  type="text"
                  className="na-search-input"
                  placeholder="Search New Arrivals (e.g. Silk, Zari, Tissue)..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                />
                {searchTerm && (
                  <button
                    type="button"
                    className="na-search-clear"
                    onClick={() => setSearchTerm("")}
                    aria-label="Clear search"
                  >
                    <X size={16} />
                  </button>
                )}
              </div>

              {/* Toolbar Actions: Sort and Price */}
              <div className="na-toolbar-actions">
                <div className="na-sort-wrap">
                  <span className="na-sort-label">Sort:</span>
                  <select
                    className="na-select"
                    value={sortBy}
                    onChange={(e) => setSortBy(e.target.value)}
                  >
                    <option value="latest">Latest Additions</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="discount">Highest Discount</option>
                    <option value="name_asc">Name: A to Z</option>
                  </select>
                </div>

                <div className="na-sort-wrap">
                  <span className="na-sort-label">Price:</span>
                  <select
                    className="na-select"
                    value={selectedPriceRange}
                    onChange={(e) => setSelectedPriceRange(e.target.value)}
                  >
                    <option value="all">All Prices</option>
                    <option value="under2500">Under INR 2,500</option>
                    <option value="2500-3500">INR 2,500 - 3,500</option>
                    <option value="3500-5000">INR 3,500 - 5,000</option>
                    <option value="above5000">Above INR 5,000</option>
                  </select>
                </div>
              </div>
            </div>

            {/* Quick Category Chips */}
            <div className="na-chips-row">
              <button
                type="button"
                className={`na-chip-btn ${
                  selectedCategory === "all" ? "active" : ""
                }`}
                onClick={() => setSelectedCategory("all")}
              >
                All New Arrivals ({initialProducts.length})
              </button>
              {categoryOptions.map((catName) => (
                <button
                  type="button"
                  key={catName}
                  className={`na-chip-btn ${
                    selectedCategory.toLowerCase() === catName.toLowerCase()
                      ? "active"
                      : ""
                  }`}
                  onClick={() => setSelectedCategory(catName)}
                >
                  {catName}
                </button>
              ))}
            </div>
          </div>

          {/* Results Summary Bar */}
          <div className="na-summary-bar">
            <span>
              Showing{" "}
              <strong className="na-results-count">
                {filteredProducts.length}
              </strong>{" "}
              handcrafted weave{filteredProducts.length === 1 ? "" : "s"}
            </span>

            {isFiltered && (
              <button
                type="button"
                className="na-clear-btn"
                onClick={clearFilters}
              >
                <X size={14} /> Clear All Filters
              </button>
            )}
          </div>

          {/* Product Grid or Empty State */}
          {filteredProducts.length === 0 ? (
            <div className="na-empty-box">
              <div className="na-empty-icon">
                <Search size={26} />
              </div>
              <h3 className="na-empty-title">No Weaves Found</h3>
              <p className="na-empty-desc">
                We couldn't find any new arrivals matching your search or filter
                criteria. Try clearing your filters to explore our full collection.
              </p>
              <button
                type="button"
                className="na-empty-reset-btn"
                onClick={clearFilters}
              >
                View All New Arrivals
              </button>
            </div>
          ) : (
            <div className="na-grid">
              {filteredProducts.map((product) => {
                const { actual, finalPrice, discountPercent } =
                  calculateFinalPrice(product);
                const imageUrl = product.cover_image
                  ? "http://localhost:8080/" + product.cover_image
                  : "/placeholder.png";
                const isLiked = wishlist[product.id];
                const isAdding = addingCartId === product.id;

                return (
                  <a
                    key={product.id}
                    href={`/detail/${product.id}`}
                    className="na-card"
                  >
                    {/* Media thumbnail */}
                    <div className="na-card-media">
                      <span className="na-badge-new">✨ New</span>
                      {discountPercent > 0 && (
                        <span className="na-badge-off">
                          {discountPercent}% OFF
                        </span>
                      )}

                      <button
                        type="button"
                        className={`na-wishlist-btn ${
                          isLiked ? "active" : ""
                        }`}
                        onClick={(e) => toggleWishlist(product.id, e)}
                        aria-label="Save to Wishlist"
                      >
                        <Heart
                          size={17}
                          fill={isLiked ? "currentColor" : "none"}
                        />
                      </button>

                      <img
                        src={imageUrl}
                        alt={product.product_name}
                        className="na-card-img"
                        loading="lazy"
                      />
                    </div>

                    {/* Card Content */}
                    <div className="na-card-content">
                      <div className="na-card-cat">
                        {product.category_name ||
                          product.fabric_type ||
                          "Maheshwari Handloom"}
                      </div>

                      <h3
                        className="na-card-title"
                        title={product.product_name}
                      >
                        {product.product_name}
                      </h3>

                      <div className="na-card-price-block">
                        <span className="na-price-final">
                          INR {formatINR(finalPrice)}
                        </span>
                        {actual > finalPrice && (
                          <>
                            <span className="na-price-mrp">
                              ₹{actual.toLocaleString("en-IN")}
                            </span>
                            <span className="na-price-disc">
                              ({discountPercent}% OFF)
                            </span>
                          </>
                        )}
                      </div>

                      <button
                        type="button"
                        className="na-quick-add-btn"
                        disabled={isAdding}
                        onClick={(e) => handleQuickAddToCart(product, e)}
                      >
                        <ShoppingBag size={15} />
                        <span>{isAdding ? "Adding..." : "Add to Cart"}</span>
                      </button>
                    </div>
                  </a>
                );
              })}
            </div>
          )}
        </div>
      </div>

      {/* Floating Call Now */}
      <a
        href="tel:+919876543210"
        className="na-floating-call"
        aria-label="Call Now"
      >
        <Phone size={15} fill="currentColor" />
        <span>Call Now</span>
      </a>

      {/* Floating WhatsApp */}
      <a
        href="https://api.whatsapp.com/send?phone=919876543210&text=Hello%20Pawar%20Handloom%2C%20I%20am%20exploring%20your%20New%20Arrivals%20collection."
        target="_blank"
        rel="noopener noreferrer"
        className="na-floating-whatsapp"
        aria-label="Chat on WhatsApp"
      >
        <MessageCircle size={26} fill="currentColor" />
      </a>
    </>
  );
}
