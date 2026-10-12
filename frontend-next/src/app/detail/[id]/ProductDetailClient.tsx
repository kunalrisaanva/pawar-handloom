"use client";

import { useState } from "react";
import {
  ArrowLeft,
  ShoppingBag,
  Truck,
  ShieldCheck,
  Heart,
  Share2,
  Check,
  Phone,
  MessageCircle,
  Sparkles,
  Info,
  Clock,
  Sparkle,
} from "lucide-react";

interface ColorItem {
  id: number;
  colour_name: string;
  colour_code: string;
  colour_rgb?: string;
}

interface ProductImageItem {
  id: number;
  product_id: number;
  image: string;
}

interface ProductDetailProps {
  product: any;
  images?: ProductImageItem[];
  colors?: ColorItem[];
  categoryName?: string;
  relatedProducts?: any[];
}

export default function ProductDetailClient({
  product,
  images = [],
  colors = [],
  categoryName = "Sarees",
  relatedProducts = [],
}: ProductDetailProps) {
  // Normalize images list: cover image + gallery images
  const allImages: string[] = [];
  if (product.cover_image) {
    allImages.push("http://localhost:8080/" + product.cover_image);
  }
  images.forEach((img) => {
    if (img.image) {
      const fullUrl = "http://localhost:8080/" + img.image;
      if (!allImages.includes(fullUrl)) {
        allImages.push(fullUrl);
      }
    }
  });
  if (allImages.length === 0) {
    allImages.push("/placeholder.png");
  }

  const [activeImage, setActiveImage] = useState<string>(allImages[0]);
  const [qty, setQty] = useState<number>(1);
  const [selectedColor, setSelectedColor] = useState<ColorItem | null>(
    colors.length > 0 ? colors[0] : null
  );
  const [adding, setAdding] = useState<boolean>(false);
  const [liked, setLiked] = useState<boolean>(false);
  const [activeTab, setActiveTab] = useState<string>("description");
  const [toastMessage, setToastMessage] = useState<string | null>(null);

  // Price calculations matching Pawar Handloom pricing rules
  const actualPrice = Number(product.actual_price_customer || product.actual_price || 0);
  const rawOffer = Number(product.offer_price || 0);

  let finalPrice = actualPrice;
  let discountPercent = 0;

  if (rawOffer > 0 && rawOffer <= 100) {
    // rawOffer is percentage discount (e.g. 10 for 10% off)
    discountPercent = Math.round(rawOffer);
    const discountAmount = (actualPrice * discountPercent) / 100;
    finalPrice = Math.max(0, actualPrice - discountAmount);
  } else if (rawOffer > 100) {
    // rawOffer is absolute final price
    finalPrice = rawOffer;
    if (actualPrice > finalPrice) {
      discountPercent = Math.round(((actualPrice - finalPrice) / actualPrice) * 100);
    }
  }

  const formatINR = (val: number) => {
    return val.toLocaleString("en-IN", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  };

  const showToast = (msg: string) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(null), 3000);
  };

  const addToCart = async () => {
    setAdding(true);
    try {
      const formData = new URLSearchParams();
      formData.append("id", product.id.toString());
      formData.append("product_name", product.product_name);
      formData.append("offer_price", finalPrice.toString());
      formData.append("qty", qty.toString());
      formData.append("image", activeImage);
      formData.append("color", selectedColor ? selectedColor.colour_name : "");

      const res = await fetch("http://localhost:8080/cart/add", {
        method: "POST",
        credentials: "include",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: formData.toString(),
      });

      const data = await res.json();
      if (data.status === "success") {
        window.dispatchEvent(new Event("cart-updated"));
        showToast("✓ Added to cart successfully!");
      } else {
        alert(data.message || "Failed to add to cart");
      }
    } catch (e) {
      console.error("Add to cart error:", e);
      alert("Error adding to cart. Please ensure backend is running.");
    } finally {
      setAdding(false);
    }
  };

  const whatsappMessage = encodeURIComponent(
    `Hello Pawar Handloom, I am interested in "${product.product_name}" (Product ID: ${product.id}) priced at INR ${formatINR(finalPrice)}. Is it available?`
  );

  return (
    <>
      <style>{`
        .product-detail-wrapper {
          background-color: #faf7f2;
          min-height: 100vh;
          padding: 30px 16px 90px;
          color: #2b2520;
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .product-detail-inner {
          max-width: 1240px;
          margin: 0 auto;
        }

        /* Breadcrumb */
        .pd-breadcrumb {
          display: flex;
          align-items: center;
          gap: 10px;
          font-size: 14px;
          color: #7d7268;
          margin-bottom: 24px;
          flex-wrap: wrap;
        }
        .pd-breadcrumb a {
          color: #a83d22;
          text-decoration: none;
          display: inline-flex;
          align-items: center;
          gap: 6px;
          font-weight: 500;
          transition: color 0.2s;
        }
        .pd-breadcrumb a:hover {
          color: #872e17;
          text-decoration: underline;
        }
        .pd-breadcrumb-sep {
          color: #c7bba8;
        }
        .pd-breadcrumb-current {
          color: #4a4036;
          font-weight: 500;
          max-width: 320px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }

        /* Main Grid */
        .pd-main-grid {
          display: grid;
          grid-template-columns: 1.15fr 1fr;
          gap: 48px;
          background: #ffffff;
          border-radius: 20px;
          padding: 40px;
          box-shadow: 0 10px 40px rgba(80, 50, 30, 0.05);
          border: 1px solid #ede3c9;
        }

        /* Gallery Layout */
        .pd-gallery-container {
          display: flex;
          gap: 20px;
          align-items: flex-start;
        }

        /* Thumbnails Strip (Left on Desktop) */
        .pd-thumbnails-strip {
          display: flex;
          flex-direction: column;
          gap: 12px;
          width: 86px;
          flex-shrink: 0;
          max-height: 580px;
          overflow-y: auto;
          scrollbar-width: thin;
        }

        .pd-thumbnail-item {
          width: 86px;
          height: 108px;
          border-radius: 10px;
          overflow: hidden;
          cursor: pointer;
          border: 2px solid #ede3c9;
          background: #fbf9f5;
          transition: all 0.2s ease;
          position: relative;
        }

        .pd-thumbnail-item:hover {
          border-color: #a83d22;
          transform: translateY(-2px);
        }

        .pd-thumbnail-item.active {
          border-color: #a83d22;
          box-shadow: 0 0 0 2px rgba(168, 61, 34, 0.25);
        }

        .pd-thumbnail-item img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
        }

        /* Main Image Showcase */
        .pd-showcase-container {
          flex: 1;
          position: relative;
          border-radius: 16px;
          overflow: hidden;
          background: #fbf9f5;
          border: 1px solid #f0e6d6;
          min-height: 480px;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .pd-showcase-img {
          width: 100%;
          height: auto;
          max-height: 640px;
          object-fit: cover;
          display: block;
          transition: transform 0.3s ease;
        }

        .pd-showcase-actions {
          position: absolute;
          top: 16px;
          right: 16px;
          display: flex;
          flex-direction: column;
          gap: 10px;
          z-index: 5;
        }

        .pd-action-icon-btn {
          width: 44px;
          height: 44px;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.92);
          backdrop-filter: blur(4px);
          border: 1px solid rgba(220, 205, 185, 0.6);
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          color: #443a32;
          box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
          transition: all 0.2s ease;
        }

        .pd-action-icon-btn:hover {
          background: #ffffff;
          transform: scale(1.08);
          color: #a83d22;
        }

        .pd-action-icon-btn.active {
          color: #e53935;
          background: #ffebee;
          border-color: #ffcdd2;
        }

        /* Product Info Side */
        .pd-info-container {
          display: flex;
          flex-direction: column;
        }

        .pd-product-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 34px;
          line-height: 1.25;
          color: #1e1915;
          margin: 0 0 16px 0;
          font-weight: 400;
          letter-spacing: -0.01em;
        }

        /* Pricing Block */
        .pd-price-row {
          display: flex;
          align-items: baseline;
          gap: 12px;
          flex-wrap: wrap;
          padding-bottom: 18px;
          border-bottom: 1px solid #f2e9dc;
          margin-bottom: 20px;
        }

        .pd-original-price {
          font-size: 19px;
          color: #8c8275;
          text-decoration: line-through;
          font-weight: 400;
        }

        .pd-final-price {
          font-size: 28px;
          color: #a83d22;
          font-weight: 700;
          letter-spacing: -0.02em;
        }

        .pd-per-piece {
          font-size: 16px;
          color: #5c5247;
          font-weight: 500;
        }

        .pd-discount-badge {
          background: #fbf1ee;
          color: #a83d22;
          font-size: 13px;
          font-weight: 700;
          padding: 4px 10px;
          border-radius: 20px;
          border: 1px solid #f2d2c7;
          letter-spacing: 0.02em;
        }

        /* Description */
        .pd-short-desc {
          color: #554a40;
          font-size: 15px;
          line-height: 1.65;
          margin-bottom: 22px;
        }

        /* Color Selection - Refined Luxury Styling */
        .pd-color-section {
          margin-bottom: 22px;
        }

        .pd-color-header {
          display: flex;
          align-items: center;
          gap: 8px;
          margin-bottom: 10px;
          font-size: 14px;
        }

        .pd-color-title {
          color: #7d7268;
          font-weight: 500;
        }

        .pd-color-name {
          color: #1e1915;
          font-weight: 700;
          letter-spacing: 0.01em;
        }

        .pd-color-chips {
          display: flex;
          gap: 10px;
          align-items: center;
          flex-wrap: wrap;
        }

        .pd-color-pill {
          display: inline-flex;
          align-items: center;
          gap: 9px;
          padding: 7px 15px 7px 10px;
          border-radius: 30px;
          border: 1.5px solid #e7ded2;
          background: #ffffff;
          cursor: pointer;
          font-size: 14px;
          color: #3b3229;
          font-weight: 500;
          transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .pd-color-pill:hover {
          border-color: #a83d22;
          background: #fdfbf8;
          transform: translateY(-1px);
        }

        .pd-color-pill.selected {
          border-color: #a83d22;
          background: #faf2ee;
          color: #a83d22;
          font-weight: 600;
          box-shadow: 0 3px 10px rgba(168, 61, 34, 0.12);
        }

        .pd-swatch-dot {
          width: 18px;
          height: 18px;
          border-radius: 50%;
          flex-shrink: 0;
          border: 1px solid rgba(0, 0, 0, 0.12);
          box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15);
        }

        .pd-check-icon {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          color: #a83d22;
          margin-left: 2px;
        }

        /* Quantity & Add to Cart */
        .pd-purchase-row {
          display: flex;
          align-items: center;
          gap: 16px;
          margin-bottom: 24px;
          flex-wrap: wrap;
        }

        .pd-qty-selector {
          display: inline-flex;
          align-items: center;
          border: 1.5px solid #d4c8b6;
          border-radius: 8px;
          background: #fbf9f5;
          height: 48px;
          overflow: hidden;
        }

        .pd-qty-btn {
          width: 44px;
          height: 100%;
          background: transparent;
          border: none;
          font-size: 18px;
          cursor: pointer;
          color: #4a4036;
          transition: background 0.15s;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .pd-qty-btn:hover {
          background: #ece3d3;
        }

        .pd-qty-value {
          width: 48px;
          text-align: center;
          font-weight: 600;
          font-size: 16px;
          color: #2b2520;
        }

        .pd-add-to-cart-btn {
          flex: 1;
          min-width: 200px;
          height: 48px;
          background: #a83d22;
          color: #ffffff;
          border: 1.5px solid #a83d22;
          border-radius: 8px;
          font-size: 15px;
          font-weight: 600;
          letter-spacing: 0.05em;
          text-transform: uppercase;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 10px;
          transition: all 0.2s ease;
          box-shadow: 0 4px 14px rgba(168, 61, 34, 0.22);
        }

        .pd-add-to-cart-btn:hover {
          background: #8b3018;
          border-color: #8b3018;
          transform: translateY(-1px);
          box-shadow: 0 6px 18px rgba(168, 61, 34, 0.32);
        }

        .pd-add-to-cart-btn:active {
          transform: translateY(0);
        }

        .pd-add-to-cart-btn:disabled {
          background: #c7bba8;
          border-color: #c7bba8;
          cursor: not-allowed;
          box-shadow: none;
        }

        /* Specifications Table */
        .pd-specifications-container {
          background: #fdfbf7;
          border-radius: 12px;
          border: 1px solid #eee5d3;
          padding: 16px 20px;
          margin-bottom: 22px;
        }

        .pd-spec-row {
          display: flex;
          justify-content: space-between;
          padding: 11px 0;
          font-size: 14.5px;
          border-bottom: 1px solid #f2e9dc;
          gap: 12px;
        }

        .pd-spec-row:last-child {
          border-bottom: none;
        }

        .pd-spec-label {
          color: #2b2520;
          font-weight: 600;
          min-width: 140px;
          flex-shrink: 0;
        }

        .pd-spec-value {
          color: #554a40;
          text-align: right;
          font-weight: 400;
          word-break: break-word;
        }

        /* Service Guarantee Row */
        .pd-guarantees-row {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 14px;
          padding-top: 14px;
          border-top: 1px solid #f0e6d6;
        }

        .pd-guarantee-item {
          display: flex;
          align-items: center;
          gap: 10px;
          color: #4a4036;
          font-size: 13.5px;
          font-weight: 500;
        }

        .pd-guarantee-icon {
          color: #a83d22;
          flex-shrink: 0;
        }

        /* Tabbed Sections */
        .pd-tabs-container {
          margin-top: 48px;
          background: #ffffff;
          border-radius: 18px;
          padding: 36px 40px;
          border: 1px solid #ede3c9;
          box-shadow: 0 4px 20px rgba(80, 50, 30, 0.03);
        }

        .pd-tabs-nav {
          display: flex;
          gap: 28px;
          border-bottom: 2px solid #f2e9dc;
          margin-bottom: 24px;
          overflow-x: auto;
          scrollbar-width: none;
        }

        .pd-tabs-nav::-webkit-scrollbar {
          display: none;
        }

        .pd-tab-btn {
          background: none;
          border: none;
          padding: 12px 4px 14px;
          font-size: 16px;
          font-weight: 600;
          color: #7d7268;
          cursor: pointer;
          position: relative;
          transition: color 0.2s;
          white-space: nowrap;
        }

        .pd-tab-btn:hover {
          color: #a83d22;
        }

        .pd-tab-btn.active {
          color: #a83d22;
        }

        .pd-tab-btn.active::after {
          content: "";
          position: absolute;
          bottom: -2px;
          left: 0;
          right: 0;
          height: 3px;
          background: #a83d22;
          border-radius: 3px;
        }

        .pd-tab-content {
          font-size: 15px;
          line-height: 1.8;
          color: #4a4036;
        }

        /* Related Products */
        .pd-related-section {
          margin-top: 60px;
        }

        .pd-related-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 32px;
          text-align: center;
          color: #2b2520;
          margin-bottom: 36px;
        }

        .pd-related-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 24px;
        }

        .pd-related-card {
          background: #ffffff;
          border-radius: 14px;
          overflow: hidden;
          border: 1px solid #ede3c9;
          text-decoration: none;
          color: inherit;
          display: flex;
          flex-direction: column;
          transition: transform 0.25s, box-shadow 0.25s;
        }

        .pd-related-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 12px 28px rgba(90, 50, 30, 0.08);
        }

        .pd-related-media {
          aspect-ratio: 3/4;
          background: #fbf9f5;
          overflow: hidden;
        }

        .pd-related-media img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.4s ease;
        }

        .pd-related-card:hover .pd-related-media img {
          transform: scale(1.04);
        }

        .pd-related-body {
          padding: 16px;
          display: flex;
          flex-direction: column;
          flex: 1;
        }

        .pd-related-name {
          font-size: 15px;
          font-weight: 600;
          color: #2b2520;
          margin-bottom: 8px;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
          height: 42px;
        }

        .pd-related-price {
          font-size: 16px;
          font-weight: 700;
          color: #a83d22;
          margin-top: auto;
        }

        /* Floating Contact Buttons */
        .pd-floating-call {
          position: fixed;
          bottom: 28px;
          left: 28px;
          background: #109cb0;
          color: #ffffff;
          border-radius: 50px;
          padding: 10px 20px;
          display: flex;
          align-items: center;
          gap: 8px;
          font-size: 14px;
          font-weight: 600;
          text-decoration: none;
          box-shadow: 0 6px 20px rgba(16, 156, 176, 0.35);
          z-index: 1000;
          transition: all 0.2s ease;
        }

        .pd-floating-call:hover {
          background: #0d8394;
          transform: translateY(-2px);
          box-shadow: 0 8px 24px rgba(16, 156, 176, 0.45);
        }

        .pd-floating-whatsapp {
          position: fixed;
          bottom: 28px;
          right: 28px;
          width: 56px;
          height: 56px;
          background: #25d366;
          color: #ffffff;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 6px 22px rgba(37, 211, 102, 0.4);
          z-index: 1000;
          text-decoration: none;
          transition: all 0.2s ease;
        }

        .pd-floating-whatsapp:hover {
          background: #20b858;
          transform: scale(1.08);
          box-shadow: 0 8px 26px rgba(37, 211, 102, 0.5);
        }

        /* Toast notification */
        .pd-toast {
          position: fixed;
          top: 24px;
          right: 24px;
          background: #2e7d32;
          color: #ffffff;
          padding: 14px 22px;
          border-radius: 10px;
          box-shadow: 0 8px 24px rgba(0,0,0,0.2);
          z-index: 2000;
          font-weight: 500;
          font-size: 15px;
          animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
          from { transform: translateX(50px); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }

        /* ════════════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS (Tablet, Mobile, Small)
           ════════════════════════════════════════════════════ */

        /* 1. Tablet & Small Laptop (max-width: 992px) */
        @media (max-width: 992px) {
          .product-detail-wrapper {
            padding: 24px 16px 85px;
          }
          .pd-main-grid {
            grid-template-columns: 1fr;
            gap: 32px;
            padding: 28px 24px;
          }
          .pd-related-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
          }
        }

        /* 2. Tablet Portrait & Mobile (max-width: 768px) */
        @media (max-width: 768px) {
          .product-detail-wrapper {
            padding: 16px 12px 95px;
          }
          .pd-breadcrumb {
            font-size: 13px;
            margin-bottom: 16px;
            gap: 6px;
          }
          .pd-breadcrumb-current {
            max-width: 180px;
          }
          .pd-gallery-container {
            flex-direction: column-reverse;
            gap: 12px;
            width: 100%;
          }
          .pd-thumbnails-strip {
            flex-direction: row;
            width: 100%;
            max-height: none;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 4px;
            gap: 10px;
            scrollbar-width: none;
          }
          .pd-thumbnails-strip::-webkit-scrollbar {
            display: none;
          }
          .pd-thumbnail-item {
            width: 70px;
            height: 90px;
            flex-shrink: 0;
            border-radius: 8px;
          }
          .pd-showcase-container {
            min-height: auto;
            max-height: 480px;
            width: 100%;
            border-radius: 12px;
            aspect-ratio: 3/4;
          }
          .pd-showcase-img {
            max-height: 480px;
            width: 100%;
            height: 100%;
            object-fit: cover;
          }
          .pd-action-icon-btn {
            width: 40px;
            height: 40px;
          }
          .pd-product-title {
            font-size: 24px;
            margin-bottom: 12px;
            line-height: 1.3;
          }
          .pd-price-row {
            gap: 8px;
            margin-bottom: 16px;
            padding-bottom: 14px;
          }
          .pd-original-price {
            font-size: 16px;
          }
          .pd-final-price {
            font-size: 24px;
          }
          .pd-per-piece {
            font-size: 14px;
          }
          .pd-discount-badge {
            font-size: 12px;
            padding: 3px 8px;
          }
          .pd-short-desc {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 18px;
          }
          .pd-tabs-container {
            padding: 22px 18px;
            border-radius: 14px;
            margin-top: 32px;
          }
          .pd-tabs-nav {
            gap: 18px;
            margin-bottom: 20px;
          }
          .pd-tab-btn {
            font-size: 14px;
            padding: 10px 2px 12px;
          }
          .pd-tab-content {
            font-size: 14px;
            line-height: 1.65;
          }
          .pd-related-section {
            margin-top: 40px;
          }
          .pd-related-title {
            font-size: 24px;
            margin-bottom: 22px;
          }
        }

        /* 3. Standard Mobile (max-width: 640px) */
        @media (max-width: 640px) {
          .pd-main-grid {
            padding: 18px 14px;
            gap: 20px;
            border-radius: 14px;
          }
          .pd-purchase-row {
            display: flex;
            flex-direction: row;
            gap: 10px;
            width: 100%;
            margin-bottom: 20px;
          }
          .pd-qty-selector {
            height: 46px;
            min-width: 110px;
            flex-shrink: 0;
          }
          .pd-qty-btn {
            width: 36px;
            font-size: 16px;
          }
          .pd-qty-value {
            width: 38px;
            font-size: 15px;
          }
          .pd-add-to-cart-btn {
            height: 46px;
            min-width: 0;
            flex: 1;
            font-size: 13.5px;
            padding: 0 10px;
            gap: 6px;
            letter-spacing: 0.02em;
          }
          .pd-color-section {
            margin-bottom: 18px;
          }
          .pd-color-chips {
            gap: 8px;
          }
          .pd-color-pill {
            padding: 6px 12px 6px 8px;
            font-size: 13px;
            gap: 7px;
          }
          .pd-swatch-dot {
            width: 16px;
            height: 16px;
          }
          .pd-specifications-container {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
          }
          .pd-spec-row {
            font-size: 13px;
            padding: 9px 0;
            gap: 8px;
          }
          .pd-spec-label {
            min-width: 110px;
            font-size: 13px;
          }
          .pd-spec-value {
            font-size: 13px;
            max-width: 65%;
          }
          .pd-guarantees-row {
            grid-template-columns: 1fr;
            gap: 8px;
            padding-top: 12px;
          }
          .pd-guarantee-item {
            font-size: 12.5px;
          }
          .pd-related-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
          }
          .pd-related-card {
            border-radius: 10px;
          }
          .pd-related-body {
            padding: 12px 8px;
          }
          .pd-related-name {
            font-size: 13px;
            height: 34px;
            line-height: 1.35;
            margin-bottom: 4px;
          }
          .pd-related-price {
            font-size: 14px;
          }
          .pd-floating-call {
            bottom: 16px;
            left: 14px;
            padding: 8px 14px;
            font-size: 12.5px;
            gap: 6px;
          }
          .pd-floating-whatsapp {
            bottom: 16px;
            right: 14px;
            width: 48px;
            height: 48px;
          }
        }

        /* 4. Extra Small Phones (max-width: 380px) */
        @media (max-width: 380px) {
          .pd-breadcrumb-current {
            max-width: 120px;
          }
          .pd-thumbnail-item {
            width: 60px;
            height: 76px;
          }
          .pd-product-title {
            font-size: 21px;
          }
          .pd-final-price {
            font-size: 21px;
          }
          .pd-floating-call .pd-call-text {
            display: none;
          }
          .pd-floating-call {
            width: 44px;
            height: 44px;
            padding: 0;
            justify-content: center;
            border-radius: 50%;
          }
          .pd-floating-whatsapp {
            width: 44px;
            height: 44px;
          }
        }
      `}</style>

      {toastMessage && <div className="pd-toast">{toastMessage}</div>}

      <div className="product-detail-wrapper">
        <div className="product-detail-inner">
          {/* Breadcrumb */}
          <div className="pd-breadcrumb">
            <a href="/">
              <ArrowLeft size={16} /> Home
            </a>
            <span className="pd-breadcrumb-sep">/</span>
            <span>{categoryName}</span>
            <span className="pd-breadcrumb-sep">/</span>
            <span className="pd-breadcrumb-current">
              {product.product_name}
            </span>
          </div>

          {/* Main Product Section */}
          <div className="pd-main-grid">
            {/* Gallery (Left) */}
            <div className="pd-gallery-container">
              {/* Vertical Thumbnail Strip */}
              <div
                className="pd-thumbnails-strip"
                aria-label="Product thumbnails"
              >
                {allImages.map((imgSrc, idx) => (
                  <div
                    key={idx}
                    className={`pd-thumbnail-item ${
                      activeImage === imgSrc ? "active" : ""
                    }`}
                    onClick={() => setActiveImage(imgSrc)}
                    onMouseEnter={() => setActiveImage(imgSrc)}
                  >
                    <img
                      src={imgSrc}
                      alt={`${product.product_name} thumbnail ${idx + 1}`}
                      loading="lazy"
                    />
                  </div>
                ))}
              </div>

              {/* Showcase Main Image */}
              <div className="pd-showcase-container">
                <img
                  src={activeImage}
                  alt={product.product_name}
                  className="pd-showcase-img"
                />
                <div className="pd-showcase-actions">
                  <button
                    type="button"
                    className={`pd-action-icon-btn ${liked ? "active" : ""}`}
                    aria-label="Add to wishlist"
                    onClick={() => setLiked(!liked)}
                  >
                    <Heart
                      size={20}
                      fill={liked ? "currentColor" : "none"}
                    />
                  </button>
                  <button
                    type="button"
                    className="pd-action-icon-btn"
                    aria-label="Share product"
                    onClick={() => {
                      if (navigator.share) {
                        navigator.share({
                          title: product.product_name,
                          url: window.location.href,
                        });
                      } else {
                        navigator.clipboard.writeText(window.location.href);
                        showToast("Link copied to clipboard!");
                      }
                    }}
                  >
                    <Share2 size={20} />
                  </button>
                </div>
              </div>
            </div>

            {/* Product Details (Right) */}
            <div className="pd-info-container">
              <h1 className="pd-product-title">{product.product_name}</h1>

              {/* Pricing */}
              <div className="pd-price-row">
                {actualPrice > 0 && actualPrice > finalPrice && (
                  <span className="pd-original-price">
                    INR {formatINR(actualPrice)}
                  </span>
                )}
                <span className="pd-final-price">
                  INR {formatINR(finalPrice)}
                </span>
                <span className="pd-per-piece">/ Per Piece</span>
                {discountPercent > 0 && (
                  <span className="pd-discount-badge">
                    ({discountPercent}% OFF)
                  </span>
                )}
              </div>

              {/* Short Description */}
              {(product.short_description || product.description) && (
                <div className="pd-short-desc">
                  {product.short_description || product.description}
                </div>
              )}

              {/* Colors Swatches */}
              {colors.length > 0 && (
                <div className="pd-color-section">
                  <div className="pd-color-header">
                    <span className="pd-color-title">Color:</span>
                    {selectedColor && (
                      <span className="pd-color-name">
                        {selectedColor.colour_name}
                      </span>
                    )}
                  </div>
                  <div className="pd-color-chips">
                    {colors.map((c) => {
                      const isSelected = selectedColor?.id === c.id;
                      return (
                        <button
                          key={c.id}
                          type="button"
                          className={`pd-color-pill ${
                            isSelected ? "selected" : ""
                          }`}
                          onClick={() => setSelectedColor(c)}
                          aria-label={`Select color ${c.colour_name}`}
                        >
                          <span
                            className="pd-swatch-dot"
                            style={{ backgroundColor: c.colour_code }}
                          />
                          <span>{c.colour_name}</span>
                          {isSelected && (
                            <span className="pd-check-icon">
                              <Check size={13} strokeWidth={2.5} />
                            </span>
                          )}
                        </button>
                      );
                    })}
                  </div>
                </div>
              )}

              {/* Quantity + Add to Cart */}
              <div className="pd-purchase-row">
                <div className="pd-qty-selector">
                  <button
                    type="button"
                    className="pd-qty-btn"
                    aria-label="Decrease quantity"
                    onClick={() => setQty(Math.max(1, qty - 1))}
                  >
                    −
                  </button>
                  <div className="pd-qty-value">{qty}</div>
                  <button
                    type="button"
                    className="pd-qty-btn"
                    aria-label="Increase quantity"
                    onClick={() => setQty(qty + 1)}
                  >
                    +
                  </button>
                </div>

                <button
                  type="button"
                  className="pd-add-to-cart-btn"
                  onClick={addToCart}
                  disabled={adding}
                >
                  <ShoppingBag size={18} />
                  {adding ? "Adding to Cart..." : "ADD TO CART"}
                </button>
              </div>

              {/* Specifications / Highlights (as seen in screenshot) */}
              <div className="pd-specifications-container">
                {product.fabric_type && (
                  <div className="pd-spec-row">
                    <span className="pd-spec-label">Fabric Type :</span>
                    <span className="pd-spec-value">{product.fabric_type}</span>
                  </div>
                )}
                {product.dimensions && (
                  <div className="pd-spec-row">
                    <span className="pd-spec-label">Dimensions :</span>
                    <span className="pd-spec-value">{product.dimensions}</span>
                  </div>
                )}
                {product.blouse_dimensions && (
                  <div className="pd-spec-row">
                    <span className="pd-spec-label">Blouse Dimensions :</span>
                    <span className="pd-spec-value">
                      {product.blouse_dimensions}
                    </span>
                  </div>
                )}
                <div className="pd-spec-row">
                  <span className="pd-spec-label">Delivery Time :</span>
                  <span className="pd-spec-value">
                    {product.delivery_time || "4 to 7 Days"}
                  </span>
                </div>
                <div className="pd-spec-row">
                  <span className="pd-spec-label">Wash Care :</span>
                  <span className="pd-spec-value">
                    {product.wash_care ||
                      "First wash dry clean and then hand wash with easy or shampoo"}
                  </span>
                </div>
                {product.material && (
                  <div className="pd-spec-row">
                    <span className="pd-spec-label">Material :</span>
                    <span className="pd-spec-value">{product.material}</span>
                  </div>
                )}
                {product.pattern && (
                  <div className="pd-spec-row">
                    <span className="pd-spec-label">Pattern :</span>
                    <span className="pd-spec-value">{product.pattern}</span>
                  </div>
                )}
              </div>

              {/* Service Badges */}
              <div className="pd-guarantees-row">
                <div className="pd-guarantee-item">
                  <Truck size={20} className="pd-guarantee-icon" />
                  <span>Fast & Insured Delivery</span>
                </div>
                <div className="pd-guarantee-item">
                  <ShieldCheck size={20} className="pd-guarantee-icon" />
                  <span>100% Authentic Handloom</span>
                </div>
              </div>
            </div>
          </div>

          {/* Tabbed Content: Description, Care & Shipping, Reviews */}
          <div className="pd-tabs-container">
            <div className="pd-tabs-nav">
              <button
                type="button"
                className={`pd-tab-btn ${
                  activeTab === "description" ? "active" : ""
                }`}
                onClick={() => setActiveTab("description")}
              >
                Description
              </button>
              <button
                type="button"
                className={`pd-tab-btn ${
                  activeTab === "care" ? "active" : ""
                }`}
                onClick={() => setActiveTab("care")}
              >
                Care & Shipping
              </button>
              <button
                type="button"
                className={`pd-tab-btn ${
                  activeTab === "features" ? "active" : ""
                }`}
                onClick={() => setActiveTab("features")}
              >
                Highlights & Features
              </button>
            </div>

            <div className="pd-tab-content">
              {activeTab === "description" && (
                <div>
                  <p>
                    {product.description ||
                      product.short_description ||
                      "Handcrafted with perfection by master artisans of Pawar Handloom in Maheshwar. Every weave tells a timeless tale of heritage, royal traditions, and unmatched elegance."}
                  </p>
                  {product.other_feature && (
                    <div style={{ marginTop: "14px" }}>
                      <strong>Note:</strong> {product.other_feature}
                    </div>
                  )}
                </div>
              )}

              {activeTab === "care" && (
                <div>
                  <h4 style={{ margin: "0 0 10px 0", color: "#a83d22" }}>
                    Washing & Maintenance
                  </h4>
                  <p>
                    {product.wash_care ||
                      "First wash dry clean and then hand wash with easy or mild shampoo in cold water. Do not wring or dry in direct harsh sunlight."}
                  </p>
                  <h4
                    style={{
                      margin: "20px 0 10px 0",
                      color: "#a83d22",
                    }}
                  >
                    Shipping & Delivery
                  </h4>
                  <p>
                    Standard dispatch timeline is{" "}
                    <strong>{product.delivery_time || "4 to 7 Days"}</strong>.
                    Pan-India courier shipping with end-to-end tracking.
                  </p>
                </div>
              )}

              {activeTab === "features" && (
                <div>
                  <ul style={{ paddingLeft: "20px", lineHeight: "2" }}>
                    <li>
                      <strong>Product Reference:</strong>{" "}
                      {product.product_reference || `PH-${product.id}`}
                    </li>
                    <li>
                      <strong>Handloom Origin:</strong> Maheshwar, Madhya
                      Pradesh
                    </li>
                    <li>
                      <strong>Fabric Composition:</strong>{" "}
                      {product.fabric_type || "Pure Silk Cotton"}
                    </li>
                    <li>
                      <strong>Return & Exchange:</strong>{" "}
                      {product.other_feature || "7 Days Exchange Available"}
                    </li>
                  </ul>
                </div>
              )}
            </div>
          </div>

          {/* Related Products */}
          {relatedProducts.length > 0 && (
            <div className="pd-related-section">
              <h2 className="pd-related-title">You May Also Like</h2>
              <div className="pd-related-grid">
                {relatedProducts.map((rel) => {
                  const relImage = rel.cover_image
                    ? "http://localhost:8080/" + rel.cover_image
                    : "/placeholder.png";
                  const relActual = Number(rel.actual_price_customer || rel.actual_price || 0);
                  const relOffer = Number(rel.offer_price || 0);
                  let relFinal = relActual;
                  if (relOffer > 0 && relOffer <= 100) {
                    relFinal = relActual - (relActual * relOffer) / 100;
                  } else if (relOffer > 100) {
                    relFinal = relOffer;
                  }
                  return (
                    <a
                      key={rel.id}
                      href={`/detail/${rel.id}`}
                      className="pd-related-card"
                    >
                      <div className="pd-related-media">
                        <img
                          src={relImage}
                          alt={rel.product_name}
                          loading="lazy"
                        />
                      </div>
                      <div className="pd-related-body">
                        <div
                          className="pd-related-name"
                          title={rel.product_name}
                        >
                          {rel.product_name}
                        </div>
                        <div className="pd-related-price">
                          INR {formatINR(relFinal)}
                        </div>
                      </div>
                    </a>
                  );
                })}
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Floating Call Now Button (as in screenshot) */}
      <a
        href="tel:+919876543210"
        className="pd-floating-call"
        aria-label="Call Now"
      >
        <Phone size={16} fill="currentColor" />
        <span className="pd-call-text">Call Now</span>
      </a>

      {/* Floating WhatsApp Button (as in screenshot) */}
      <a
        href={`https://api.whatsapp.com/send?phone=919876543210&text=${whatsappMessage}`}
        target="_blank"
        rel="noopener noreferrer"
        className="pd-floating-whatsapp"
        aria-label="Chat on WhatsApp"
      >
        <MessageCircle size={28} fill="currentColor" />
      </a>
    </>
  );
}
