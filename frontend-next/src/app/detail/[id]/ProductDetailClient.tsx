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
  Star,
  ThumbsUp,
  Upload,
  X,
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
  initialReviews?: any[];
}

export default function ProductDetailClient({
  product,
  images = [],
  colors = [],
  categoryName = "Sarees",
  relatedProducts = [],
  initialReviews = [],
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

  // Reviews state
  const [reviewsList, setReviewsList] = useState<any[]>(initialReviews);
  const [likedReviews, setLikedReviews] = useState<Record<number, boolean>>({});

  // Review submission form state
  const [reviewRating, setReviewRating] = useState<number>(5);
  const [hoverRating, setHoverRating] = useState<number>(0);
  const [reviewTitle, setReviewTitle] = useState<string>("");
  const [reviewText, setReviewText] = useState<string>("");
  const [reviewName, setReviewName] = useState<string>("");
  const [reviewEmail, setReviewEmail] = useState<string>("");
  const [reviewYoutube, setReviewYoutube] = useState<string>("");
  const [reviewFiles, setReviewFiles] = useState<File[]>([]);
  const [submittingReview, setSubmittingReview] = useState<boolean>(false);

  const handleLikeReview = async (reviewId: number) => {
    if (likedReviews[reviewId]) return;
    try {
      const formData = new URLSearchParams();
      formData.append("id", reviewId.toString());
      const res = await fetch("http://localhost:8080/review/like", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: formData.toString(),
      });
      const data = await res.json();
      if (data.status === "success") {
        setLikedReviews((prev) => ({ ...prev, [reviewId]: true }));
        setReviewsList((prev) =>
          prev.map((r) =>
            r.id === reviewId ? { ...r, likes: (Number(r.likes) || 0) + 1 } : r
          )
        );
      }
    } catch (err) {
      console.error("Like review error:", err);
    }
  };

  const handleReviewSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!reviewName.trim() || !reviewText.trim()) {
      alert("Please provide your name and review comments.");
      return;
    }
    setSubmittingReview(true);
    try {
      const formData = new FormData();
      formData.append("product_id", product.id.toString());
      formData.append("user_id", "0");
      formData.append("rating", reviewRating.toString());
      formData.append("review_title", reviewTitle);
      formData.append("review_text", reviewText);
      formData.append("name", reviewName);
      formData.append("email", reviewEmail);
      formData.append("YouTube_url", reviewYoutube);
      reviewFiles.forEach((file) => {
        formData.append("review_image[]", file);
      });

      const res = await fetch("http://localhost:8080/review/save", {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: formData,
      });

      const data = await res.json().catch(() => ({}));
      showToast("✓ Thank you! Your review has been submitted.");

      const newRev = {
        id: (data as any)?.review_id || Date.now(),
        name: reviewName,
        rating: reviewRating,
        review_title: reviewTitle,
        review_text: reviewText,
        likes: 0,
        created_at: new Date().toISOString(),
        review_images: reviewFiles.length > 0 ? "submitted" : null,
      };
      setReviewsList((prev) => [newRev, ...prev]);

      setReviewRating(5);
      setReviewTitle("");
      setReviewText("");
      setReviewName("");
      setReviewEmail("");
      setReviewYoutube("");
      setReviewFiles([]);
      setActiveTab("customer_review");
    } catch (err) {
      console.error("Submit review error:", err);
      showToast("✓ Review submitted successfully!");
      setActiveTab("customer_review");
    } finally {
      setSubmittingReview(false);
    }
  };

  const scrollToTabsSection = (tabKey: string) => {
    setActiveTab(tabKey);
    const tabsEl = document.getElementById("product-tabs-section");
    if (tabsEl) {
      tabsEl.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  };

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

        /* Tabbed Sections matching Pawar reference image */
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
          align-items: center;
          justify-content: center;
          gap: 16px;
          margin-bottom: 34px;
          flex-wrap: wrap;
        }

        .pd-tab-btn {
          background: transparent;
          border: 1px solid transparent;
          padding: 10px 26px;
          border-radius: 9999px;
          font-size: 15px;
          font-weight: 500;
          color: #4b5563;
          cursor: pointer;
          transition: all 0.2s ease;
          white-space: nowrap;
          text-decoration: none;
        }

        .pd-tab-btn:hover {
          color: #111827;
        }

        .pd-tab-btn.active {
          border: 1.5px solid #1f2937;
          background: #ffffff;
          color: #111827;
          font-weight: 600;
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .pd-tab-content {
          font-size: 15px;
          line-height: 1.8;
          color: #4a4036;
        }

        .pd-tab-pane {
          animation: pdFadeIn 0.25s ease-in-out;
        }

        @keyframes pdFadeIn {
          from { opacity: 0; transform: translateY(4px); }
          to { opacity: 1; transform: translateY(0); }
        }

        /* Description tab */
        .pd-desc-text {
          font-size: 15px;
          line-height: 1.75;
          color: #2b2520;
          margin: 0 0 22px 0;
        }

        .pd-desc-table-wrap {
          width: 100%;
          overflow-x: auto;
          margin-top: 20px;
        }

        .pd-desc-table {
          width: 100%;
          border-collapse: collapse;
          border: 1px solid #e5e7eb;
          background: #ffffff;
        }

        .pd-desc-table td {
          padding: 16px 24px;
          border: 1px solid #e5e7eb;
          font-size: 14.5px;
          color: #1f2937;
        }

        .pd-desc-td-label {
          width: 40%;
          font-weight: 600;
          color: #1f2937;
          background: #fafaf9;
        }

        .pd-desc-td-value {
          color: #374151;
        }

        /* Additional Information Grid */
        .pd-additional-grid {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 20px;
        }

        .pd-info-card {
          background: #fcfbf9;
          border: 1px solid #f0e6d6;
          border-radius: 12px;
          padding: 22px;
        }

        .pd-info-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 19px;
          color: #a83d22;
          margin: 0 0 10px 0;
        }

        .pd-info-card p {
          font-size: 14px;
          line-height: 1.65;
          color: #4a4036;
          margin: 0 0 10px 0;
        }

        .pd-info-list {
          margin: 8px 0 0 18px;
          padding: 0;
          font-size: 13.5px;
          line-height: 1.6;
          color: #4a4036;
        }

        .pd-info-note {
          background: rgba(168, 61, 34, 0.08);
          border-left: 3px solid #a83d22;
          padding: 8px 12px;
          border-radius: 4px;
          font-size: 13px;
          color: #6a2412;
          margin-top: 8px;
        }

        /* Write a Review Form */
        .pd-review-form-wrap {
          max-width: 680px;
          margin: 0 auto;
        }

        .pd-review-form-title {
          font-family: 'DM Serif Display', Georgia, serif;
          font-size: 24px;
          color: #2b2520;
          margin-bottom: 20px;
          text-align: center;
        }

        .pd-form-group {
          margin-bottom: 18px;
        }

        .pd-form-label {
          display: block;
          font-size: 13.5px;
          font-weight: 600;
          color: #2b2520;
          margin-bottom: 7px;
        }

        .pd-star-picker {
          display: flex;
          gap: 6px;
          align-items: center;
        }

        .pd-star-btn {
          background: none;
          border: none;
          cursor: pointer;
          padding: 2px;
          color: #d1d5db;
          transition: transform 0.15s, color 0.15s;
        }

        .pd-star-btn:hover {
          transform: scale(1.15);
        }

        .pd-star-btn.filled {
          color: #f59e0b;
        }

        .pd-input, .pd-textarea {
          width: 100%;
          padding: 12px 14px;
          border-radius: 9px;
          border: 1px solid #dcd1be;
          background: #ffffff;
          font-size: 14px;
          color: #1f2937;
          font-family: inherit;
          transition: border-color 0.2s, box-shadow 0.2s;
          box-sizing: border-box;
        }

        .pd-input:focus, .pd-textarea:focus {
          outline: none;
          border-color: #a83d22;
          box-shadow: 0 0 0 3px rgba(168, 61, 34, 0.12);
        }

        .pd-form-row {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 16px;
        }

        .pd-file-dropzone {
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 14px 18px;
          border: 1.5px dashed #c9beab;
          border-radius: 10px;
          background: #faf7f2;
          cursor: pointer;
          transition: border-color 0.2s;
        }

        .pd-file-dropzone:hover {
          border-color: #a83d22;
        }

        .pd-submit-review-btn {
          background: #a83d22;
          color: #ffffff;
          border: none;
          padding: 13px 28px;
          border-radius: 9999px;
          font-size: 14.5px;
          font-weight: 600;
          cursor: pointer;
          transition: background 0.2s, transform 0.15s;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          width: 100%;
          margin-top: 10px;
        }

        .pd-submit-review-btn:hover {
          background: #8b321a;
          transform: translateY(-1px);
        }

        .pd-submit-review-btn:disabled {
          opacity: 0.7;
          cursor: not-allowed;
        }

        /* Customer Reviews List */
        .pd-customer-reviews-wrap {
          width: 100%;
        }

        .pd-reviews-header-bar {
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding-bottom: 20px;
          margin-bottom: 24px;
          border-bottom: 1px solid #f0e6d6;
          flex-wrap: wrap;
          gap: 14px;
        }

        .pd-write-review-cta-btn {
          background: #ffffff;
          border: 1.5px solid #a83d22;
          color: #a83d22;
          font-weight: 600;
          font-size: 13.5px;
          padding: 8px 18px;
          border-radius: 9999px;
          cursor: pointer;
          transition: all 0.2s;
        }

        .pd-write-review-cta-btn:hover {
          background: #a83d22;
          color: #ffffff;
        }

        .pd-empty-reviews {
          text-align: center;
          padding: 40px 20px;
          background: #fbf9f5;
          border-radius: 12px;
          border: 1px dashed #dcd1be;
        }

        .pd-empty-review-btn {
          background: #a83d22;
          color: #ffffff;
          border: none;
          padding: 10px 22px;
          border-radius: 9999px;
          font-size: 14px;
          font-weight: 600;
          cursor: pointer;
        }

        .pd-reviews-card-list {
          display: flex;
          flex-direction: column;
          gap: 18px;
        }

        .pd-review-card {
          background: #fcfbf9;
          border: 1px solid #ede3c9;
          border-radius: 12px;
          padding: 20px 24px;
          transition: box-shadow 0.2s;
        }

        .pd-review-card:hover {
          box-shadow: 0 4px 14px rgba(80, 50, 30, 0.05);
        }

        .pd-review-card-head {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 10px;
          flex-wrap: wrap;
          gap: 8px;
        }

        .pd-reviewer-avatar {
          width: 36px;
          height: 36px;
          border-radius: 50%;
          background: #f0e6d6;
          color: #a83d22;
          font-weight: 700;
          font-size: 15px;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .pd-reviewer-name {
          font-weight: 600;
          font-size: 14.5px;
          color: #1f2937;
        }

        .pd-review-stars {
          display: flex;
          gap: 2px;
          margin-top: 2px;
        }

        .pd-review-date {
          font-size: 12.5px;
          color: #887b70;
        }

        .pd-review-card-title {
          font-weight: 600;
          font-size: 14.5px;
          color: #2b2520;
          margin: 0 0 6px 0;
        }

        .pd-review-card-text {
          font-size: 14px;
          line-height: 1.6;
          color: #4a4036;
          margin: 0 0 10px 0;
        }

        .pd-review-images-strip {
          display: flex;
          gap: 10px;
          margin-top: 10px;
          flex-wrap: wrap;
        }

        .pd-review-thumb-img {
          width: 70px;
          height: 70px;
          object-fit: cover;
          border-radius: 8px;
          border: 1px solid #ede3c9;
        }

        .pd-review-like-btn {
          background: #ffffff;
          border: 1px solid #e5dccb;
          border-radius: 9999px;
          padding: 5px 12px;
          font-size: 12.5px;
          color: #555555;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          gap: 6px;
          transition: all 0.2s;
        }

        .pd-review-like-btn:hover {
          border-color: #a83d22;
          color: #a83d22;
        }

        .pd-review-like-btn.liked {
          background: #faf2ee;
          border-color: #a83d22;
          color: #a83d22;
        }

        /* Sticky vertical review button on right edge */
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
          transition: background 0.25s, box-shadow 0.25s, transform 0.2s;
        }

        .sticky-review-pawar .review-btn:hover {
          background: #000000;
          box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
          transform: translateY(-50%) translateX(-2px);
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
            gap: 12px;
            margin-bottom: 24px;
            justify-content: center;
          }
          .pd-tab-btn {
            font-size: 14px;
            padding: 8px 20px;
          }
          .pd-additional-grid {
            grid-template-columns: 1fr;
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

        /* 3. Standard Mobile (max-width: 640px) tabs styling */
        @media (max-width: 640px) {
          .pd-tabs-nav {
            justify-content: flex-start;
            overflow-x: auto;
            flex-wrap: nowrap;
            padding-bottom: 8px;
            gap: 8px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
          }
          .pd-tabs-nav::-webkit-scrollbar {
            display: none;
          }
          .pd-tab-btn {
            font-size: 13.5px;
            padding: 8px 18px;
            flex-shrink: 0;
          }
          .pd-desc-table td {
            padding: 12px 14px;
            font-size: 13.5px;
          }
          .pd-desc-td-label {
            width: 45%;
          }
          .pd-form-row {
            grid-template-columns: 1fr;
            gap: 12px;
          }
          .pd-reviews-header-bar {
            flex-direction: column;
            align-items: flex-start;
          }
        }

        /* 4. Small Phones (max-width: 480px) */
        @media (max-width: 480px) {
          .sticky-review-pawar {
            display: none;
          }
        }

        /* 5. Extra Small Phones (max-width: 380px) */
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

          {/* Tabbed Content: Description, Additional Info, Write Review, Customer Review */}
          <div id="product-tabs-section" className="pd-tabs-container">
            <div className="pd-tabs-nav" role="tablist">
              <button
                type="button"
                role="tab"
                aria-selected={activeTab === "description"}
                className={`pd-tab-btn ${
                  activeTab === "description" ? "active" : ""
                }`}
                onClick={() => setActiveTab("description")}
              >
                Description
              </button>
              <button
                type="button"
                role="tab"
                aria-selected={activeTab === "additional_info"}
                className={`pd-tab-btn ${
                  activeTab === "additional_info" ? "active" : ""
                }`}
                onClick={() => setActiveTab("additional_info")}
              >
                Additional Information
              </button>
              <button
                type="button"
                role="tab"
                aria-selected={activeTab === "write_review"}
                className={`pd-tab-btn ${
                  activeTab === "write_review" ? "active" : ""
                }`}
                onClick={() => setActiveTab("write_review")}
              >
                Write a Review
              </button>
              <button
                type="button"
                role="tab"
                aria-selected={activeTab === "customer_review"}
                className={`pd-tab-btn ${
                  activeTab === "customer_review" ? "active" : ""
                }`}
                onClick={() => setActiveTab("customer_review")}
              >
                Customer Review{reviewsList.length > 0 ? ` (${reviewsList.length})` : ""}
              </button>
            </div>

            <div className="pd-tab-content">
              {/* Tab 1: Description */}
              {activeTab === "description" && (
                <div className="pd-tab-pane">
                  <p className="pd-desc-text">
                    {product.description
                      ? product.description.trim()
                      : product.short_description
                      ? product.short_description.trim()
                      : "The saree has flower buties and skirt boarder.its come with a contrast blouse piece with heavy zari weaving pallu. Fabric of the saree is Maheshwari cotton by silk"}
                  </p>

                  <div className="pd-desc-table-wrap">
                    <table className="pd-desc-table">
                      <tbody>
                        <tr>
                          <td className="pd-desc-td-label">Other Feature</td>
                          <td className="pd-desc-td-value">
                            {product.other_feature && product.other_feature.trim()
                              ? product.other_feature.trim()
                              : "7 Days exchange"}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              )}

              {/* Tab 2: Additional Information */}
              {activeTab === "additional_info" && (
                <div className="pd-tab-pane">
                  <div className="pd-additional-grid">
                    <div className="pd-info-card">
                      <h3 className="pd-info-title">Wash Care</h3>
                      <p>
                        Dry clean only for the first two washes. For subsequent washes, gently
                        hand wash using a mild silk-safe detergent or shampoo. Always air-dry
                        handloom articles in the shade and iron on medium heat only.
                      </p>
                      <ul className="pd-info-list">
                        <li>Dry clean recommended: first 2 washes</li>
                        <li>Gentle hand wash thereafter (silk-safe detergent)</li>
                        <li>Air dry in shade — avoid direct sunlight</li>
                        <li>Iron at medium heat</li>
                      </ul>
                    </div>

                    <div className="pd-info-card">
                      <h3 className="pd-info-title">Shipping & Delivery</h3>
                      <p>
                        Orders are dispatched within <strong>1–2 business days</strong> of
                        order placement. Typical delivery times are{" "}
                        <strong>{product.delivery_time || "4–7 business days"}</strong> for
                        domestic shipments pan-India.
                      </p>
                      <div className="pd-info-note">
                        Same-day local delivery is available in <strong>Indore</strong> for
                        orders placed before 4:00 PM.
                      </div>
                    </div>

                    <div className="pd-info-card">
                      <h3 className="pd-info-title">International Shipments</h3>
                      <p>
                        Any import taxes, customs duties, or other charges levied by the
                        destination country are the responsibility of the customer. If the
                        carrier pays these on your behalf, you will be required to reimburse
                        the carrier.
                      </p>
                    </div>

                    <div className="pd-info-card">
                      <h3 className="pd-info-title">Authenticity & Color Disclaimer</h3>
                      <p>
                        Every handloom creation is hand-woven by master weavers of
                        Maheshwar. Subtle nuances in texture, zari motifs, and selvedge are
                        natural characteristics of authentic handlooms. Actual colors may
                        vary slightly due to monitor calibration and photography lighting.
                      </p>
                    </div>
                  </div>
                </div>
              )}

              {/* Tab 3: Write a Review */}
              {activeTab === "write_review" && (
                <div className="pd-tab-pane">
                  <div className="pd-review-form-wrap">
                    <h3 className="pd-review-form-title">Write a Review</h3>
                    <form onSubmit={handleReviewSubmit} className="pd-review-form">
                      <div className="pd-form-group">
                        <label className="pd-form-label">Your Rating</label>
                        <div className="pd-star-picker">
                          {[1, 2, 3, 4, 5].map((starVal) => {
                            const isFilled =
                              (hoverRating || reviewRating) >= starVal;
                            return (
                              <button
                                type="button"
                                key={starVal}
                                className={`pd-star-btn ${isFilled ? "filled" : ""}`}
                                onClick={() => setReviewRating(starVal)}
                                onMouseEnter={() => setHoverRating(starVal)}
                                onMouseLeave={() => setHoverRating(0)}
                                aria-label={`Rate ${starVal} out of 5 stars`}
                              >
                                <Star
                                  size={24}
                                  fill={isFilled ? "#f59e0b" : "none"}
                                  stroke={isFilled ? "#f59e0b" : "#d1d5db"}
                                />
                              </button>
                            );
                          })}
                          <span style={{ fontSize: "14px", fontWeight: 600, color: "#a83d22", marginLeft: "10px" }}>
                            {reviewRating} of 5 Stars
                          </span>
                        </div>
                      </div>

                      <div className="pd-form-group">
                        <label className="pd-form-label">Review Title</label>
                        <input
                          type="text"
                          className="pd-input"
                          placeholder="e.g. Magnificent Handloom Saree, Exquisite Weave!"
                          value={reviewTitle}
                          onChange={(e) => setReviewTitle(e.target.value)}
                        />
                      </div>

                      <div className="pd-form-group">
                        <label className="pd-form-label">Review Content *</label>
                        <textarea
                          className="pd-textarea"
                          rows={4}
                          placeholder="Share details of your experience with the fabric, zari border, color, and packaging..."
                          value={reviewText}
                          onChange={(e) => setReviewText(e.target.value)}
                          required
                        />
                      </div>

                      <div className="pd-form-row">
                        <div className="pd-form-group">
                          <label className="pd-form-label">Your Name *</label>
                          <input
                            type="text"
                            className="pd-input"
                            placeholder="e.g. Priya Sharma"
                            value={reviewName}
                            onChange={(e) => setReviewName(e.target.value)}
                            required
                          />
                        </div>

                        <div className="pd-form-group">
                          <label className="pd-form-label">Email Address *</label>
                          <input
                            type="email"
                            className="pd-input"
                            placeholder="e.g. priya@example.com"
                            value={reviewEmail}
                            onChange={(e) => setReviewEmail(e.target.value)}
                            required
                          />
                        </div>
                      </div>

                      <div className="pd-form-group">
                        <label className="pd-form-label">YouTube Video URL (Optional)</label>
                        <input
                          type="url"
                          className="pd-input"
                          placeholder="https://www.youtube.com/watch?v=..."
                          value={reviewYoutube}
                          onChange={(e) => setReviewYoutube(e.target.value)}
                        />
                      </div>

                      <div className="pd-form-group">
                        <label className="pd-form-label">Upload Photos (Optional)</label>
                        <label className="pd-file-dropzone">
                          <input
                            type="file"
                            multiple
                            accept="image/*"
                            style={{ display: "none" }}
                            onChange={(e) => {
                              if (e.target.files) {
                                setReviewFiles(Array.from(e.target.files));
                              }
                            }}
                          />
                          <Upload size={20} color="#a83d22" />
                          <span style={{ fontSize: "14px", color: "#6b7280" }}>
                            {reviewFiles.length > 0
                              ? `${reviewFiles.length} file(s) selected`
                              : "Click to upload product photos"}
                          </span>
                        </label>
                        {reviewFiles.length > 0 && (
                          <div style={{ display: "flex", gap: "8px", marginTop: "10px", flexWrap: "wrap" }}>
                            {reviewFiles.map((f, i) => (
                              <span
                                key={i}
                                style={{
                                  background: "#f0e6d6",
                                  color: "#2b2520",
                                  padding: "4px 10px",
                                  borderRadius: "6px",
                                  fontSize: "12px",
                                }}
                              >
                                {f.name}
                              </span>
                            ))}
                          </div>
                        )}
                      </div>

                      <button
                        type="submit"
                        className="pd-submit-review-btn"
                        disabled={submittingReview}
                      >
                        {submittingReview ? "Submitting Review..." : "Submit Review"}
                      </button>
                    </form>
                  </div>
                </div>
              )}

              {/* Tab 4: Customer Review */}
              {activeTab === "customer_review" && (
                <div className="pd-tab-pane">
                  <div className="pd-customer-reviews-wrap">
                    <div className="pd-reviews-header-bar">
                      <div>
                        <h3
                          style={{
                            fontFamily: "'DM Serif Display', Georgia, serif",
                            fontSize: "24px",
                            color: "#2b2520",
                            margin: 0,
                          }}
                        >
                          Customer Reviews
                        </h3>
                        <p style={{ margin: "4px 0 0 0", color: "#7d7268", fontSize: "14px" }}>
                          {reviewsList.length} verified review{reviewsList.length === 1 ? "" : "s"} for this product
                        </p>
                      </div>

                      <button
                        type="button"
                        onClick={() => setActiveTab("write_review")}
                        className="pd-write-review-cta-btn"
                      >
                        Write a Review
                      </button>
                    </div>

                    {reviewsList.length === 0 ? (
                      <div className="pd-empty-reviews">
                        <p style={{ fontSize: "15px", color: "#6b7280", margin: "0 0 16px 0" }}>
                          No customer reviews yet. Be the first to review this authentic handloom saree!
                        </p>
                        <button
                          type="button"
                          onClick={() => setActiveTab("write_review")}
                          className="pd-empty-review-btn"
                        >
                          Write the First Review
                        </button>
                      </div>
                    ) : (
                      <div className="pd-reviews-card-list">
                        {reviewsList.map((rev: any) => {
                          const revRating = Number(rev.rating) || 5;
                          const revImages = rev.review_images
                            ? rev.review_images.split(",").filter(Boolean)
                            : [];
                          const isLiked = likedReviews[rev.id];

                          return (
                            <div key={rev.id} className="pd-review-card">
                              <div className="pd-review-card-head">
                                <div style={{ display: "flex", alignItems: "center", gap: "10px" }}>
                                  <div className="pd-reviewer-avatar">
                                    {(rev.name || "Customer").charAt(0).toUpperCase()}
                                  </div>
                                  <div>
                                    <div className="pd-reviewer-name">
                                      {rev.name || "Customer"}
                                    </div>
                                    <div className="pd-review-stars">
                                      {[1, 2, 3, 4, 5].map((s) => (
                                        <Star
                                          key={s}
                                          size={14}
                                          fill={s <= revRating ? "#f59e0b" : "none"}
                                          stroke={s <= revRating ? "#f59e0b" : "#d1d5db"}
                                        />
                                      ))}
                                    </div>
                                  </div>
                                </div>

                                <span className="pd-review-date">
                                  {rev.created_at
                                    ? new Date(rev.created_at).toLocaleDateString("en-IN", {
                                        day: "numeric",
                                        month: "short",
                                        year: "numeric",
                                      })
                                    : "Verified Buyer"}
                                </span>
                              </div>

                              {rev.review_title && (
                                <h4 className="pd-review-card-title">{rev.review_title}</h4>
                              )}

                              <p className="pd-review-card-text">{rev.review_text}</p>

                              {revImages.length > 0 && (
                                <div className="pd-review-images-strip">
                                  {revImages.map((img: string, idx: number) => (
                                    <img
                                      key={idx}
                                      src={`http://localhost:8080/uploads/review_images/${img}`}
                                      alt="Customer photo"
                                      className="pd-review-thumb-img"
                                    />
                                  ))}
                                </div>
                              )}

                              <div style={{ marginTop: "12px", display: "flex", alignItems: "center", gap: "12px" }}>
                                <button
                                  type="button"
                                  onClick={() => handleLikeReview(rev.id)}
                                  className={`pd-review-like-btn ${isLiked ? "liked" : ""}`}
                                  disabled={isLiked}
                                  aria-label="Like review"
                                >
                                  <ThumbsUp size={14} />
                                  <span>Helpful ({rev.likes || 0})</span>
                                </button>
                              </div>
                            </div>
                          );
                        })}
                      </div>
                    )}
                  </div>
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

      {/* Floating Sticky Reviews Button on Right Edge */}
      <div className="sticky-review-pawar">
        <button
          type="button"
          className="review-btn"
          onClick={() => scrollToTabsSection("customer_review")}
          aria-label="Open Customer Reviews"
        >
          <svg viewBox="0 0 24 24" className="star-icon">
            <path d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
          </svg>
          <span className="review-text">Reviews</span>
        </button>
      </div>
    </>
  );
}
