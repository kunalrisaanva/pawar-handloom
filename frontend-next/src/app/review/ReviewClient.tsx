"use client";

import React, { useState, useMemo, useEffect } from "react";
import SharedLayout from "@/components/SharedLayout";
import {
  Star,
  ThumbsUp,
  CheckCircle2,
  Camera,
  Upload,
  X,
  Search,
  ArrowUpDown,
  Sparkles,
  Store,
  ShoppingBag,
  ChevronRight,
  MessageSquarePlus,
  Play,
  ChevronLeft,
} from "lucide-react";

export interface ReviewItem {
  id: number;
  user_id?: number;
  product_id?: number;
  product_name?: string;
  name: string;
  email?: string;
  rating: number;
  review_title: string;
  review_text: string;
  review_type: 1 | 2; // 1 = Product Review, 2 = Shop Review
  likes: number;
  created_at: string;
  location?: string;
  verified: boolean;
  review_images?: string[];
  YouTube_url?: string;
}

export interface ReviewStats {
  averageRating: number;
  totalReviews: number;
  ratingCounts: Record<number, number>;
}

export default function ReviewClient({
  initialReviews = [],
  initialStats,
}: {
  initialReviews?: ReviewItem[];
  initialStats?: ReviewStats;
}) {
  const [reviews, setReviews] = useState<ReviewItem[]>(initialReviews);
  const [activeTab, setActiveTab] = useState<"all" | "product" | "shop" | "photos">("all");
  const [ratingFilter, setRatingFilter] = useState<number | 0>(0);
  const [sortBy, setSortBy] = useState<"newest" | "highest" | "helpful">("newest");
  const [searchQuery, setSearchQuery] = useState("");
  const [likedMap, setLikedMap] = useState<Record<number, boolean>>({});

  // Client-side fallback fetch from CodeIgniter review API if no SSR reviews loaded
  useEffect(() => {
    if (initialReviews && initialReviews.length > 0) return;

    fetch("http://localhost:8080/review/api")
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          const allReviews: ReviewItem[] = [
            ...(data.productReviews || []),
            ...(data.shopReviews || []),
          ].map((r: any) => {
            const imgList = r.review_images
              ? r.review_images
                  .split(",")
                  .map((img: string) => img.trim())
                  .filter(Boolean)
                  .map((img: string) =>
                    img.startsWith("http")
                      ? img
                      : `http://localhost:8080/public/uploads/review_images/${img}`
                  )
              : [];

            return {
              id: Number(r.id),
              user_id: Number(r.user_id || 0),
              product_id: Number(r.product_id || 0),
              product_name: r.product_name,
              name: r.name?.trim() || "Customer",
              email: r.email || "",
              rating: Math.max(1, Math.min(5, Number(r.rating || 5))),
              review_title: r.review_title?.trim() || "Customer Experience",
              review_text: r.review_text?.trim() || "",
              review_type: Number(r.review_type) === 1 ? 1 : 2,
              likes: Number(r.likes || 0),
              created_at: r.created_at,
              verified: true,
              review_images: imgList,
              YouTube_url: r.YouTube_url || "",
            };
          });
          setReviews(allReviews);
        }
      })
      .catch((err) => console.error("Error fetching reviews from backend:", err));
  }, [initialReviews]);

  // Write Review Modal state
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [formType, setFormType] = useState<1 | 2>(2); // 2 = Store, 1 = Product
  const [formRating, setFormRating] = useState(5);
  const [hoverRating, setHoverRating] = useState(0);
  const [formTitle, setFormTitle] = useState("");
  const [formText, setFormText] = useState("");
  const [formName, setFormName] = useState("");
  const [formEmail, setFormEmail] = useState("");
  const [formYoutube, setFormYoutube] = useState("");
  const [selectedFiles, setSelectedFiles] = useState<File[]>([]);
  const [imagePreviewUrls, setImagePreviewUrls] = useState<string[]>([]);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitSuccess, setSubmitSuccess] = useState(false);

  // Lightbox preview modal state
  const [lightboxImg, setLightboxImg] = useState<string | null>(null);

  // Carousel index map for reviews with multiple images
  const [carouselIndexMap, setCarouselIndexMap] = useState<Record<number, number>>({});

  // Dynamic Statistics calculation based on live reviews
  const totalReviews = reviews.length;
  const ratingCounts = useMemo(() => {
    if (initialStats && reviews.length === initialReviews.length) {
      return initialStats.ratingCounts;
    }
    const counts: Record<number, number> = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 };
    reviews.forEach((r) => {
      const star = Math.max(1, Math.min(5, Math.round(r.rating)));
      counts[star] = (counts[star] || 0) + 1;
    });
    return counts;
  }, [reviews, initialStats, initialReviews.length]);

  const averageRating = useMemo(() => {
    if (initialStats && reviews.length === initialReviews.length) {
      return initialStats.averageRating;
    }
    if (totalReviews === 0) return 0;
    const sum = reviews.reduce((acc, curr) => acc + curr.rating, 0);
    return Number((sum / totalReviews).toFixed(1));
  }, [reviews, totalReviews, initialStats, initialReviews.length]);

  // Handle like button: update UI and POST to CodeIgniter backend
  const handleLike = async (id: number) => {
    const isCurrentlyLiked = likedMap[id];
    setLikedMap((prev) => ({ ...prev, [id]: !isCurrentlyLiked }));
    setReviews((prev) =>
      prev.map((r) =>
        r.id === id ? { ...r, likes: isCurrentlyLiked ? Math.max(0, r.likes - 1) : r.likes + 1 } : r
      )
    );

    try {
      const formData = new URLSearchParams();
      formData.append("id", String(id));
      const res = await fetch("http://localhost:8080/review/like", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: formData.toString(),
      });
      const data = await res.json();
      if (data.status === "success" && data.likes !== undefined) {
        setReviews((prev) =>
          prev.map((r) => (r.id === id ? { ...r, likes: Number(data.likes) } : r))
        );
      }
    } catch (err) {
      console.error("Failed to sync like with backend:", err);
    }
  };

  // Filtered and Sorted Reviews
  const filteredReviews = useMemo(() => {
    return reviews
      .filter((r) => {
        // Tab filter (matching CodeIgniter: Product Reviews & Shop Reviews)
        if (activeTab === "product" && r.review_type !== 1) return false;
        if (activeTab === "shop" && r.review_type !== 2) return false;
        if (activeTab === "photos" && (!r.review_images || r.review_images.length === 0))
          return false;

        // Rating filter
        if (ratingFilter > 0 && Math.round(r.rating) !== ratingFilter) return false;

        // Search query
        if (searchQuery.trim()) {
          const q = searchQuery.toLowerCase();
          const matchTitle = (r.review_title || "").toLowerCase().includes(q);
          const matchText = (r.review_text || "").toLowerCase().includes(q);
          const matchName = (r.name || "").toLowerCase().includes(q);
          const matchProduct = (r.product_name || "").toLowerCase().includes(q);
          if (!matchTitle && !matchText && !matchName && !matchProduct) return false;
        }

        return true;
      })
      .sort((a, b) => {
        if (sortBy === "highest") return b.rating - a.rating;
        if (sortBy === "helpful") return b.likes - a.likes;
        return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
      });
  }, [reviews, activeTab, ratingFilter, sortBy, searchQuery]);

  // Handle Form Submission: POST to CodeIgniter backend (/review/save)
  const handleSubmitReview = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!formTitle.trim() || !formText.trim() || !formName.trim()) {
      alert("Please fill in the required fields: Title, Review, and Name.");
      return;
    }

    setIsSubmitting(true);

    try {
      const formData = new FormData();
      formData.append("reviewShop", "1");
      formData.append("user_id", "0");
      formData.append("product_id", formType === 1 ? "1" : "0");
      formData.append("review_title", formTitle.trim());
      formData.append("rating", String(formRating));
      formData.append("review_text", formText.trim());
      formData.append("YouTube_url", formYoutube.trim());
      formData.append("name", formName.trim());
      formData.append("email", formEmail.trim());
      selectedFiles.forEach((file) => {
        formData.append("review_image[]", file);
      });

      const res = await fetch("http://localhost:8080/review/save", {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: formData,
      });

      const result = await res.json().catch(() => ({ status: "success" }));

      const newReview: ReviewItem = {
        id: result.review_id ? Number(result.review_id) : Date.now(),
        product_id: formType === 1 ? 1 : 0,
        product_name: formType === 1 ? "Maheshwari Handloom Saree" : undefined,
        name: formName.trim(),
        email: formEmail.trim(),
        rating: formRating,
        review_title: formTitle.trim(),
        review_text: formText.trim(),
        review_type: formType,
        likes: 0,
        created_at: new Date().toISOString(),
        verified: true,
        review_images: imagePreviewUrls.length > 0 ? imagePreviewUrls : undefined,
        YouTube_url: formYoutube.trim() || undefined,
      };

      setReviews((prev) => [newReview, ...prev]);
      setIsSubmitting(false);
      setSubmitSuccess(true);

      setTimeout(() => {
        setSubmitSuccess(false);
        setIsFormOpen(false);
        setFormTitle("");
        setFormText("");
        setFormName("");
        setFormEmail("");
        setFormYoutube("");
        setSelectedFiles([]);
        setImagePreviewUrls([]);
        setFormRating(5);
      }, 1500);
    } catch (err) {
      console.error("Error submitting review to backend:", err);
      setIsSubmitting(false);
      alert("Your review was submitted! Refresh the page to see changes.");
      setIsFormOpen(false);
    }
  };

  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files) {
      const files = Array.from(e.target.files);
      setSelectedFiles((prev) => [...prev, ...files]);
      const urls = files.map((f) => URL.createObjectURL(f));
      setImagePreviewUrls((prev) => [...prev, ...urls]);
    }
  };

  const removeUploadImage = (idx: number) => {
    setSelectedFiles((prev) => prev.filter((_, i) => i !== idx));
    setImagePreviewUrls((prev) => prev.filter((_, i) => i !== idx));
  };

  return (
    <SharedLayout>
      {/* ══════════ HERO SECTION ══════════ */}
      <section
        style={{
          background: "linear-gradient(135deg, #1f1b18 0%, #2e2621 100%)",
          color: "#fff",
          padding: "70px 20px 80px",
          position: "relative",
          overflow: "hidden",
          textAlign: "center",
        }}
      >
        <div
          style={{
            position: "absolute",
            inset: 0,
            opacity: 0.08,
            backgroundImage: "radial-gradient(#b8860b 1px, transparent 1px)",
            backgroundSize: "24px 24px",
          }}
        />

        <div style={{ maxWidth: "800px", margin: "0 auto", position: "relative", zIndex: 1 }}>
          {/* Breadcrumb */}
          <div
            style={{
              display: "inline-flex",
              alignItems: "center",
              gap: "8px",
              fontSize: "0.85rem",
              color: "#d4af37",
              marginBottom: "16px",
              letterSpacing: "1px",
              textTransform: "uppercase",
            }}
          >
            <a href="/" style={{ color: "#d4af37", textDecoration: "none" }}>
              Home
            </a>
            <ChevronRight size={14} />
            <span style={{ color: "#eee" }}>Customer Reviews</span>
          </div>

          <h1
            style={{
              fontFamily: "var(--font-serif)",
              fontSize: "clamp(2.2rem, 5vw, 3.4rem)",
              fontWeight: 700,
              color: "#fcf8f2",
              margin: "0 0 16px",
              letterSpacing: "0.5px",
            }}
          >
            Customer Reviews & Experiences
          </h1>

          <p
            style={{
              fontSize: "clamp(1rem, 2vw, 1.15rem)",
              lineHeight: 1.7,
              color: "#d1c7bc",
              maxWidth: "660px",
              margin: "0 auto 28px",
            }}
          >
            Read authentic reviews, unboxing impressions, and customer drape stories from our
            community of Maheshwari & Chanderi patrons across the globe.
          </p>

          <div
            style={{
              display: "inline-flex",
              alignItems: "center",
              gap: "12px",
              background: "rgba(255, 255, 255, 0.08)",
              backdropFilter: "blur(8px)",
              padding: "10px 24px",
              borderRadius: "50px",
              border: "1px solid rgba(212, 175, 55, 0.3)",
            }}
          >
            <div style={{ display: "flex", gap: "3px", color: "#f59e0b" }}>
              {[1, 2, 3, 4, 5].map((s) => (
                <Star key={s} size={18} fill="#f59e0b" strokeWidth={0} />
              ))}
            </div>
            <span style={{ fontWeight: 600, fontSize: "1rem", color: "#fff" }}>
              {averageRating} out of 5.0
            </span>
            <span style={{ color: "#d1c7bc", fontSize: "0.9rem" }}>
              ({totalReviews} Verified Stories)
            </span>
          </div>
        </div>
      </section>

      {/* ══════════ MAIN CONTENT CONTAINER ══════════ */}
      <div style={{ maxWidth: "1240px", margin: "-35px auto 80px", padding: "0 20px" }}>
        {/* ── SUMMARY STATS CARD (Matching old site breakdown) ── */}
        <div
          style={{
            background: "#fff",
            borderRadius: "20px",
            padding: "36px 32px",
            boxShadow: "0 12px 35px rgba(0, 0, 0, 0.06)",
            border: "1px solid #f0e6d6",
            display: "grid",
            gridTemplateColumns: "repeat(auto-fit, minmax(280px, 1fr))",
            gap: "36px",
            alignItems: "center",
            marginBottom: "40px",
          }}
        >
          {/* Column 1: Big Rating Display */}
          <div style={{ textAlign: "center", paddingRight: "16px" }}>
            <div
              style={{
                fontSize: "4.2rem",
                fontWeight: 800,
                color: "#222",
                fontFamily: "var(--font-serif)",
                lineHeight: 1,
              }}
            >
              {averageRating}
            </div>
            <div
              style={{
                display: "flex",
                justifyContent: "center",
                gap: "4px",
                color: "#f59e0b",
                margin: "12px 0 8px",
              }}
            >
              {[1, 2, 3, 4, 5].map((star) => (
                <Star
                  key={star}
                  size={22}
                  fill={star <= Math.round(averageRating) ? "#f59e0b" : "none"}
                  strokeWidth={star <= Math.round(averageRating) ? 0 : 1.5}
                />
              ))}
            </div>
            <p style={{ color: "#666", fontSize: "0.95rem", margin: 0 }}>
              Based on <strong>{totalReviews}</strong> customer reviews
            </p>
            <div
              style={{
                display: "inline-flex",
                alignItems: "center",
                gap: "6px",
                marginTop: "12px",
                fontSize: "0.85rem",
                color: "#166534",
                background: "#f0fdf4",
                padding: "4px 12px",
                borderRadius: "20px",
                fontWeight: 600,
              }}
            >
              <CheckCircle2 size={15} /> 100% Genuine Weaves
            </div>
          </div>

          {/* Column 2: Rating Progress Bars */}
          <div style={{ display: "flex", flexDirection: "column", gap: "8px" }}>
            {[5, 4, 3, 2, 1].map((stars) => {
              const count = ratingCounts[stars] || 0;
              const percent = totalReviews > 0 ? (count / totalReviews) * 100 : 0;
              const isSelected = ratingFilter === stars;

              return (
                <div
                  key={stars}
                  onClick={() => setRatingFilter(isSelected ? 0 : stars)}
                  style={{
                    display: "flex",
                    alignItems: "center",
                    gap: "12px",
                    cursor: "pointer",
                    padding: "4px 8px",
                    borderRadius: "8px",
                    background: isSelected ? "#fcf8f2" : "transparent",
                    transition: "all 0.2s",
                  }}
                  title={`Filter by ${stars} stars`}
                >
                  <span
                    style={{
                      fontSize: "0.9rem",
                      fontWeight: 600,
                      color: "#444",
                      width: "48px",
                      display: "flex",
                      alignItems: "center",
                      gap: "4px",
                    }}
                  >
                    {stars} <Star size={13} fill="#f59e0b" strokeWidth={0} />
                  </span>
                  <div
                    style={{
                      flex: 1,
                      height: "10px",
                      backgroundColor: "#f3ede3",
                      borderRadius: "5px",
                      overflow: "hidden",
                    }}
                  >
                    <div
                      style={{
                        width: `${percent}%`,
                        height: "100%",
                        backgroundColor: "#b8860b",
                        borderRadius: "5px",
                        transition: "width 0.6s ease",
                      }}
                    />
                  </div>
                  <span
                    style={{
                      fontSize: "0.85rem",
                      color: "#777",
                      width: "36px",
                      textAlign: "right",
                    }}
                  >
                    {count}
                  </span>
                </div>
              );
            })}
          </div>

          {/* Column 3: Write Review CTA */}
          <div
            style={{
              textAlign: "center",
              display: "flex",
              flexDirection: "column",
              alignItems: "center",
              justifyContent: "center",
              paddingLeft: "16px",
              borderLeft: "1px dashed #e8dccb",
            }}
          >
            <div
              style={{
                width: "56px",
                height: "56px",
                borderRadius: "50%",
                background: "#fcf8f2",
                color: "#b8860b",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                marginBottom: "14px",
              }}
            >
              <MessageSquarePlus size={28} />
            </div>
            <h3
              style={{
                fontSize: "1.2rem",
                color: "#222",
                fontWeight: 700,
                marginBottom: "6px",
                fontFamily: "var(--font-serif)",
              }}
            >
              Write a Review
            </h3>
            <p style={{ color: "#666", fontSize: "0.88rem", marginBottom: "18px", maxWidth: "260px" }}>
              Share your feedback or unboxing photos with fellow handloom connoisseurs.
            </p>
            <button
              onClick={() => setIsFormOpen(true)}
              style={{
                display: "inline-flex",
                alignItems: "center",
                gap: "8px",
                background: "linear-gradient(135deg, #2b2b2b 0%, #111 100%)",
                color: "#fff",
                border: "none",
                borderRadius: "30px",
                padding: "12px 28px",
                fontSize: "0.95rem",
                fontWeight: 600,
                cursor: "pointer",
                boxShadow: "0 6px 18px rgba(0,0,0,0.15)",
                transition: "all 0.25s",
              }}
              onMouseEnter={(e) => {
                e.currentTarget.style.transform = "translateY(-2px)";
                e.currentTarget.style.boxShadow = "0 8px 22px rgba(0,0,0,0.22)";
              }}
              onMouseLeave={(e) => {
                e.currentTarget.style.transform = "none";
                e.currentTarget.style.boxShadow = "0 6px 18px rgba(0,0,0,0.15)";
              }}
            >
              <Sparkles size={16} fill="#f59e0b" strokeWidth={0} /> Write a Review
            </button>
          </div>
        </div>

        {/* ── FILTER & SORT CONTROLS ── */}
        <div
          style={{
            background: "#faf7f2",
            borderRadius: "16px",
            padding: "16px 20px",
            display: "flex",
            flexWrap: "wrap",
            gap: "16px",
            justifyContent: "space-between",
            alignItems: "center",
            marginBottom: "32px",
            border: "1px solid #ede3d3",
          }}
        >
          {/* Tabs matching old site: Product Reviews & Shop Reviews */}
          <div style={{ display: "flex", gap: "8px", flexWrap: "wrap" }}>
            {[
              { id: "all", label: `All Reviews (${totalReviews})` },
              {
                id: "product",
                label: `Product Reviews (${reviews.filter((r) => r.review_type === 1).length})`,
              },
              {
                id: "shop",
                label: `Shop Reviews (${reviews.filter((r) => r.review_type === 2).length})`,
              },
              {
                id: "photos",
                label: `With Photos (${
                  reviews.filter((r) => r.review_images && r.review_images.length > 0).length
                })`,
              },
            ].map((tab) => (
              <button
                key={tab.id}
                onClick={() => setActiveTab(tab.id as any)}
                style={{
                  background: activeTab === tab.id ? "#b8860b" : "#fff",
                  color: activeTab === tab.id ? "#fff" : "#444",
                  border: activeTab === tab.id ? "1px solid #b8860b" : "1px solid #ddd",
                  borderRadius: "20px",
                  padding: "8px 18px",
                  fontSize: "0.85rem",
                  fontWeight: 600,
                  cursor: "pointer",
                  transition: "all 0.2s",
                }}
              >
                {tab.label}
              </button>
            ))}
          </div>

          {/* Search, Filter & Sort */}
          <div style={{ display: "flex", gap: "12px", alignItems: "center", flexWrap: "wrap" }}>
            <div
              style={{
                position: "relative",
                display: "flex",
                alignItems: "center",
                background: "#fff",
                borderRadius: "20px",
                padding: "6px 14px",
                border: "1px solid #ddd",
              }}
            >
              <Search size={14} color="#888" style={{ marginRight: "6px" }} />
              <input
                type="text"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                placeholder="Search reviews..."
                style={{
                  border: "none",
                  outline: "none",
                  fontSize: "0.85rem",
                  width: "140px",
                  background: "transparent",
                }}
              />
              {searchQuery && (
                <X
                  size={14}
                  color="#999"
                  style={{ cursor: "pointer" }}
                  onClick={() => setSearchQuery("")}
                />
              )}
            </div>

            {/* Rating Filter Tag */}
            {ratingFilter > 0 && (
              <button
                onClick={() => setRatingFilter(0)}
                style={{
                  background: "#fee2e2",
                  color: "#991b1b",
                  border: "none",
                  borderRadius: "20px",
                  padding: "6px 12px",
                  fontSize: "0.8rem",
                  fontWeight: 600,
                  cursor: "pointer",
                  display: "flex",
                  alignItems: "center",
                  gap: "4px",
                }}
              >
                {ratingFilter} Stars <X size={12} />
              </button>
            )}

            {/* Sort Dropdown */}
            <div
              style={{
                display: "flex",
                alignItems: "center",
                gap: "6px",
                background: "#fff",
                borderRadius: "20px",
                padding: "6px 14px",
                border: "1px solid #ddd",
                fontSize: "0.85rem",
              }}
            >
              <ArrowUpDown size={14} color="#777" />
              <select
                value={sortBy}
                onChange={(e) => setSortBy(e.target.value as any)}
                style={{
                  border: "none",
                  outline: "none",
                  background: "transparent",
                  fontSize: "0.85rem",
                  color: "#444",
                  cursor: "pointer",
                }}
              >
                <option value="newest">Most Recent</option>
                <option value="highest">Highest Rating</option>
                <option value="helpful">Most Helpful</option>
              </select>
            </div>
          </div>
        </div>

        {/* ── REVIEW CARDS LIST ── */}
        {filteredReviews.length === 0 ? (
          <div
            style={{
              textAlign: "center",
              padding: "60px 20px",
              background: "#fff",
              borderRadius: "16px",
              border: "1px dashed #d5c8b5",
            }}
          >
            <MessageSquarePlus size={44} color="#b8860b" style={{ marginBottom: "12px" }} />
            <h3 style={{ fontSize: "1.3rem", color: "#333", fontWeight: 700 }}>
              No reviews found
            </h3>
            <p style={{ color: "#777", fontSize: "0.9rem", marginBottom: "20px" }}>
              Be the first to share your experience!
            </p>
            <button
              onClick={() => setIsFormOpen(true)}
              style={{
                background: "#b8860b",
                color: "#fff",
                border: "none",
                borderRadius: "25px",
                padding: "10px 24px",
                fontSize: "0.9rem",
                fontWeight: 600,
                cursor: "pointer",
              }}
            >
              Write a Review
            </button>
          </div>
        ) : (
          <div
            style={{
              display: "grid",
              gridTemplateColumns: "repeat(auto-fill, minmax(360px, 1fr))",
              gap: "24px",
            }}
          >
            {filteredReviews.map((review) => {
              const isLiked = likedMap[review.id];
              const images = review.review_images || [];
              const currentImgIdx = carouselIndexMap[review.id] || 0;

              return (
                <div
                  key={review.id}
                  style={{
                    background: "#fff",
                    borderRadius: "18px",
                    padding: "26px",
                    boxShadow: "0 6px 20px rgba(0,0,0,0.04)",
                    border: "1px solid #f2ece1",
                    display: "flex",
                    flexDirection: "column",
                    justifyContent: "space-between",
                    transition: "transform 0.25s, box-shadow 0.25s",
                  }}
                  onMouseEnter={(e) => {
                    e.currentTarget.style.transform = "translateY(-4px)";
                    e.currentTarget.style.boxShadow = "0 12px 28px rgba(0,0,0,0.08)";
                  }}
                  onMouseLeave={(e) => {
                    e.currentTarget.style.transform = "none";
                    e.currentTarget.style.boxShadow = "0 6px 20px rgba(0,0,0,0.04)";
                  }}
                >
                  <div>
                    {/* Header: Author & Date */}
                    <div
                      style={{
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "space-between",
                        marginBottom: "14px",
                      }}
                    >
                      <div style={{ display: "flex", alignItems: "center", gap: "12px" }}>
                        <div
                          style={{
                            width: "44px",
                            height: "44px",
                            borderRadius: "50%",
                            background:
                              "linear-gradient(135deg, #f5ebd9 0%, #e8d7bb 100%)",
                            color: "#8a660a",
                            fontWeight: 700,
                            fontSize: "1rem",
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "center",
                            fontFamily: "var(--font-serif)",
                            boxShadow: "0 2px 6px rgba(0,0,0,0.05)",
                          }}
                        >
                          {(review.name || "Customer")
                            .split(" ")
                            .map((n) => n[0])
                            .slice(0, 2)
                            .join("")}
                        </div>
                        <div>
                          <div
                            style={{
                              fontWeight: 700,
                              fontSize: "0.95rem",
                              color: "#222",
                              display: "flex",
                              alignItems: "center",
                              gap: "6px",
                            }}
                          >
                            {review.name || "Customer"}
                            {review.verified && (
                              <CheckCircle2
                                size={14}
                                color="#16a34a"
                                title="Verified Customer"
                              />
                            )}
                          </div>
                          <span style={{ fontSize: "0.8rem", color: "#888" }}>
                            {review.location || "Verified Patron"} •{" "}
                            {new Date(review.created_at).toLocaleDateString("en-IN", {
                              day: "numeric",
                              month: "short",
                              year: "numeric",
                            })}
                          </span>
                        </div>
                      </div>

                      {/* Review Type Badge (matching old site: About Product / About Shop) */}
                      <span
                        style={{
                          fontSize: "0.75rem",
                          fontWeight: 600,
                          padding: "4px 10px",
                          borderRadius: "12px",
                          background: review.review_type === 1 ? "#fef3c7" : "#e0f2fe",
                          color: review.review_type === 1 ? "#92400e" : "#0369a1",
                          display: "inline-flex",
                          alignItems: "center",
                          gap: "4px",
                        }}
                      >
                        {review.review_type === 1 ? (
                          <>
                            <ShoppingBag size={12} /> About Product
                          </>
                        ) : (
                          <>
                            <Store size={12} /> About Shop
                          </>
                        )}
                      </span>
                    </div>

                    {/* Star Rating */}
                    <div
                      style={{
                        display: "flex",
                        alignItems: "center",
                        gap: "3px",
                        marginBottom: "12px",
                        color: "#f59e0b",
                      }}
                    >
                      {[1, 2, 3, 4, 5].map((star) => (
                        <Star
                          key={star}
                          size={16}
                          fill={star <= review.rating ? "#f59e0b" : "none"}
                          strokeWidth={star <= review.rating ? 0 : 1.5}
                        />
                      ))}
                      <span
                        style={{
                          fontSize: "0.85rem",
                          fontWeight: 700,
                          color: "#333",
                          marginLeft: "6px",
                        }}
                      >
                        {review.rating}.0
                      </span>
                    </div>

                    {/* Review Title */}
                    <h4
                      style={{
                        fontFamily: "var(--font-serif)",
                        fontSize: "1.1rem",
                        fontWeight: 700,
                        color: "#222",
                        marginBottom: "10px",
                        lineHeight: 1.35,
                      }}
                    >
                      {review.review_title}
                    </h4>

                    {/* Review Body */}
                    <p
                      style={{
                        fontSize: "0.9rem",
                        color: "#555",
                        lineHeight: 1.65,
                        marginBottom: "16px",
                      }}
                    >
                      {review.review_text}
                    </p>

                    {/* Product Name if present */}
                    {review.product_name && (
                      <div
                        style={{
                          background: "#faf8f5",
                          border: "1px solid #eee5d7",
                          padding: "8px 12px",
                          borderRadius: "8px",
                          fontSize: "0.8rem",
                          color: "#777",
                          marginBottom: "16px",
                          display: "flex",
                          alignItems: "center",
                          gap: "6px",
                        }}
                      >
                        <span style={{ fontWeight: 600, color: "#444" }}>Product:</span>{" "}
                        {review.product_name}
                      </div>
                    )}

                    {/* Image Carousel (matching old site's multi-image carousel) */}
                    {images.length > 0 && (
                      <div
                        style={{
                          position: "relative",
                          width: "100%",
                          height: "220px",
                          borderRadius: "12px",
                          overflow: "hidden",
                          marginBottom: "16px",
                          background: "#f7f7f7",
                        }}
                      >
                        <img
                          src={images[currentImgIdx % images.length]}
                          alt="Review attachment"
                          onClick={() => setLightboxImg(images[currentImgIdx % images.length])}
                          style={{
                            width: "100%",
                            height: "100%",
                            objectFit: "cover",
                            cursor: "zoom-in",
                          }}
                        />

                        {images.length > 1 && (
                          <>
                            <button
                              type="button"
                              onClick={(e) => {
                                e.stopPropagation();
                                setCarouselIndexMap((prev) => ({
                                  ...prev,
                                  [review.id]:
                                    (currentImgIdx - 1 + images.length) % images.length,
                                }));
                              }}
                              style={{
                                position: "absolute",
                                left: 8,
                                top: "50%",
                                transform: "translateY(-50%)",
                                background: "rgba(0,0,0,0.5)",
                                color: "#fff",
                                border: "none",
                                borderRadius: "50%",
                                width: "28px",
                                height: "28px",
                                display: "flex",
                                alignItems: "center",
                                justifyContent: "center",
                                cursor: "pointer",
                              }}
                            >
                              <ChevronLeft size={16} />
                            </button>
                            <button
                              type="button"
                              onClick={(e) => {
                                e.stopPropagation();
                                setCarouselIndexMap((prev) => ({
                                  ...prev,
                                  [review.id]: (currentImgIdx + 1) % images.length,
                                }));
                              }}
                              style={{
                                position: "absolute",
                                right: 8,
                                top: "50%",
                                transform: "translateY(-50%)",
                                background: "rgba(0,0,0,0.5)",
                                color: "#fff",
                                border: "none",
                                borderRadius: "50%",
                                width: "28px",
                                height: "28px",
                                display: "flex",
                                alignItems: "center",
                                justifyContent: "center",
                                cursor: "pointer",
                              }}
                            >
                              <ChevronRight size={16} />
                            </button>
                            <div
                              style={{
                                position: "absolute",
                                bottom: 8,
                                left: "50%",
                                transform: "translateX(-50%)",
                                background: "rgba(0,0,0,0.6)",
                                color: "#fff",
                                padding: "2px 8px",
                                borderRadius: "10px",
                                fontSize: "0.75rem",
                              }}
                            >
                              {currentImgIdx + 1} / {images.length}
                            </div>
                          </>
                        )}
                      </div>
                    )}

                    {/* YouTube Video link if present */}
                    {review.YouTube_url && (
                      <a
                        href={
                          review.YouTube_url.startsWith("http://") ||
                          review.YouTube_url.startsWith("https://")
                            ? review.YouTube_url
                            : `https://${review.YouTube_url}`
                        }
                        target="_blank"
                        rel="noreferrer"
                        style={{
                          display: "inline-flex",
                          alignItems: "center",
                          gap: "6px",
                          fontSize: "0.8rem",
                          color: "#dc2626",
                          marginBottom: "14px",
                          textDecoration: "none",
                          fontWeight: 600,
                        }}
                      >
                        <Play size={14} fill="currentColor" /> Watch Video Review
                      </a>
                    )}
                  </div>

                  {/* Card Footer: Helpful Like Button (matching CodeIgniter like AJAX) */}
                  <div
                    style={{
                      borderTop: "1px solid #f5ede0",
                      paddingTop: "14px",
                      marginTop: "10px",
                      display: "flex",
                      alignItems: "center",
                      justifyContent: "space-between",
                    }}
                  >
                    <span style={{ fontSize: "0.8rem", color: "#999" }}>
                      Was this review helpful?
                    </span>
                    <button
                      type="button"
                      onClick={() => handleLike(review.id)}
                      style={{
                        display: "inline-flex",
                        alignItems: "center",
                        gap: "6px",
                        background: isLiked ? "#fef3c7" : "#faf7f2",
                        color: isLiked ? "#b8860b" : "#666",
                        border: isLiked ? "1px solid #f59e0b" : "1px solid #ede3d3",
                        borderRadius: "20px",
                        padding: "5px 14px",
                        fontSize: "0.8rem",
                        fontWeight: 600,
                        cursor: "pointer",
                        transition: "all 0.2s",
                      }}
                    >
                      <ThumbsUp
                        size={13}
                        fill={isLiked ? "currentColor" : "none"}
                        strokeWidth={1.75}
                      />
                      <span>Helpful ({review.likes})</span>
                    </button>
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </div>

      {/* ══════════ WRITE A REVIEW MODAL / DRAWER ══════════ */}
      {isFormOpen && (
        <div
          style={{
            position: "fixed",
            inset: 0,
            background: "rgba(0, 0, 0, 0.65)",
            backdropFilter: "blur(6px)",
            zIndex: 10000,
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            padding: "20px",
          }}
          onClick={(e) => {
            if (e.target === e.currentTarget) setIsFormOpen(false);
          }}
        >
          <div
            style={{
              background: "#fff",
              borderRadius: "24px",
              maxWidth: "600px",
              width: "100%",
              maxHeight: "90vh",
              overflowY: "auto",
              boxShadow: "0 24px 60px rgba(0,0,0,0.25)",
              border: "1px solid #eae0d0",
              padding: "36px 32px",
              position: "relative",
              animation: "fadeInUp 0.3s ease",
            }}
          >
            {/* Close Button */}
            <button
              onClick={() => setIsFormOpen(false)}
              style={{
                position: "absolute",
                top: "22px",
                right: "22px",
                background: "#f3ede3",
                border: "none",
                borderRadius: "50%",
                width: "36px",
                height: "36px",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                cursor: "pointer",
                color: "#555",
              }}
            >
              <X size={18} />
            </button>

            {submitSuccess ? (
              <div style={{ textAlign: "center", padding: "40px 10px" }}>
                <div
                  style={{
                    width: "70px",
                    height: "70px",
                    borderRadius: "50%",
                    background: "#dcfce7",
                    color: "#15803d",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    margin: "0 auto 16px",
                  }}
                >
                  <CheckCircle2 size={40} />
                </div>
                <h3
                  style={{
                    fontFamily: "var(--font-serif)",
                    fontSize: "1.8rem",
                    color: "#222",
                    marginBottom: "8px",
                  }}
                >
                  Thank You, {formName}!
                </h3>
                <p style={{ color: "#666", fontSize: "0.95rem" }}>
                  Your review has been submitted successfully. It inspires fellow patrons and
                  celebrates the artisans of Maheshwar!
                </p>
              </div>
            ) : (
              <form onSubmit={handleSubmitReview}>
                <div style={{ marginBottom: "24px" }}>
                  <span
                    style={{
                      color: "#b8860b",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      letterSpacing: "1px",
                      textTransform: "uppercase",
                    }}
                  >
                    Share Your Voice
                  </span>
                  <h2
                    style={{
                      fontFamily: "var(--font-serif)",
                      fontSize: "1.8rem",
                      color: "#222",
                      fontWeight: 700,
                      margin: "4px 0 8px",
                    }}
                  >
                    Write a Review
                  </h2>
                  <p style={{ color: "#777", fontSize: "0.9rem", margin: 0 }}>
                    Please share details about your drape, weave texture, packaging, and overall service.
                  </p>
                </div>

                {/* Review Type Choice (matching CodeIgniter review_type: 1 or 2) */}
                <div style={{ marginBottom: "20px" }}>
                  <label
                    style={{
                      display: "block",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      color: "#444",
                      marginBottom: "8px",
                    }}
                  >
                    Review Type *
                  </label>
                  <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "10px" }}>
                    <button
                      type="button"
                      onClick={() => setFormType(2)}
                      style={{
                        padding: "10px",
                        borderRadius: "12px",
                        border: formType === 2 ? "2px solid #b8860b" : "1px solid #ddd",
                        background: formType === 2 ? "#fcf8f2" : "#fff",
                        color: formType === 2 ? "#8a660a" : "#666",
                        fontWeight: 600,
                        fontSize: "0.9rem",
                        cursor: "pointer",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        gap: "6px",
                      }}
                    >
                      <Store size={16} /> Store Review
                    </button>
                    <button
                      type="button"
                      onClick={() => setFormType(1)}
                      style={{
                        padding: "10px",
                        borderRadius: "12px",
                        border: formType === 1 ? "2px solid #b8860b" : "1px solid #ddd",
                        background: formType === 1 ? "#fcf8f2" : "#fff",
                        color: formType === 1 ? "#8a660a" : "#666",
                        fontWeight: 600,
                        fontSize: "0.9rem",
                        cursor: "pointer",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        gap: "6px",
                      }}
                    >
                      <ShoppingBag size={16} /> Product Review
                    </button>
                  </div>
                </div>

                {/* Interactive Star Rating */}
                <div style={{ marginBottom: "22px" }}>
                  <label
                    style={{
                      display: "block",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      color: "#444",
                      marginBottom: "8px",
                    }}
                  >
                    Your Overall Rating *
                  </label>
                  <div style={{ display: "flex", alignItems: "center", gap: "8px" }}>
                    <div style={{ display: "flex", gap: "6px" }}>
                      {[1, 2, 3, 4, 5].map((star) => {
                        const activeVal = hoverRating || formRating;
                        return (
                          <button
                            key={star}
                            type="button"
                            onClick={() => setFormRating(star)}
                            onMouseEnter={() => setHoverRating(star)}
                            onMouseLeave={() => setHoverRating(0)}
                            style={{
                              background: "none",
                              border: "none",
                              cursor: "pointer",
                              padding: "2px",
                              color: star <= activeVal ? "#f59e0b" : "#d1d5db",
                              transition: "transform 0.15s",
                            }}
                          >
                            <Star
                              size={28}
                              fill={star <= activeVal ? "#f59e0b" : "none"}
                              strokeWidth={star <= activeVal ? 0 : 1.5}
                            />
                          </button>
                        );
                      })}
                    </div>
                    <span
                      style={{
                        fontSize: "0.9rem",
                        fontWeight: 600,
                        color: "#b8860b",
                        marginLeft: "8px",
                      }}
                    >
                      {formRating === 5 && "Exceptional (5.0)"}
                      {formRating === 4 && "Very Good (4.0)"}
                      {formRating === 3 && "Average (3.0)"}
                      {formRating === 2 && "Fair (2.0)"}
                      {formRating === 1 && "Poor (1.0)"}
                    </span>
                  </div>
                </div>

                {/* Title */}
                <div style={{ marginBottom: "18px" }}>
                  <label
                    style={{
                      display: "block",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      color: "#444",
                      marginBottom: "6px",
                    }}
                  >
                    Review Title *
                  </label>
                  <input
                    type="text"
                    required
                    value={formTitle}
                    onChange={(e) => setFormTitle(e.target.value)}
                    placeholder="e.g. Royal drape and immaculate gold zari border"
                    style={{
                      width: "100%",
                      padding: "11px 14px",
                      borderRadius: "10px",
                      border: "1px solid #dcd3c5",
                      outline: "none",
                      fontSize: "0.9rem",
                    }}
                  />
                </div>

                {/* Content */}
                <div style={{ marginBottom: "18px" }}>
                  <label
                    style={{
                      display: "block",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      color: "#444",
                      marginBottom: "6px",
                    }}
                  >
                    Your Detailed Review *
                  </label>
                  <textarea
                    required
                    rows={4}
                    value={formText}
                    onChange={(e) => setFormText(e.target.value)}
                    placeholder="Describe how the fabric felt, how it draped, dispatch speed, and overall satisfaction..."
                    style={{
                      width: "100%",
                      padding: "11px 14px",
                      borderRadius: "10px",
                      border: "1px solid #dcd3c5",
                      outline: "none",
                      fontSize: "0.9rem",
                      fontFamily: "inherit",
                    }}
                  />
                </div>

                {/* Photos Upload Dropzone */}
                <div style={{ marginBottom: "18px" }}>
                  <label
                    style={{
                      display: "block",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      color: "#444",
                      marginBottom: "6px",
                    }}
                  >
                    Add Photos (Optional)
                  </label>
                  <label
                    style={{
                      display: "flex",
                      flexDirection: "column",
                      alignItems: "center",
                      justifyContent: "center",
                      border: "2px dashed #d5c8b5",
                      borderRadius: "12px",
                      padding: "20px",
                      cursor: "pointer",
                      background: "#fcf8f2",
                    }}
                  >
                    <Upload size={24} color="#b8860b" style={{ marginBottom: "6px" }} />
                    <span style={{ fontSize: "0.85rem", fontWeight: 600, color: "#555" }}>
                      Upload photos from your device
                    </span>
                    <span style={{ fontSize: "0.75rem", color: "#888" }}>
                      PNG, JPG up to 10MB
                    </span>
                    <input
                      type="file"
                      multiple
                      accept="image/*"
                      onChange={handleImageUpload}
                      style={{ display: "none" }}
                    />
                  </label>

                  {/* Uploaded thumbnails */}
                  {imagePreviewUrls.length > 0 && (
                    <div style={{ display: "flex", gap: "8px", marginTop: "10px", flexWrap: "wrap" }}>
                      {imagePreviewUrls.map((url, i) => (
                        <div
                          key={i}
                          style={{
                            width: "56px",
                            height: "56px",
                            borderRadius: "8px",
                            overflow: "hidden",
                            position: "relative",
                          }}
                        >
                          <img
                            src={url}
                            alt="upload preview"
                            style={{ width: "100%", height: "100%", objectFit: "cover" }}
                          />
                          <button
                            type="button"
                            onClick={() => removeUploadImage(i)}
                            style={{
                              position: "absolute",
                              top: 2,
                              right: 2,
                              background: "rgba(0,0,0,0.6)",
                              color: "#fff",
                              border: "none",
                              borderRadius: "50%",
                              width: "16px",
                              height: "16px",
                              display: "flex",
                              alignItems: "center",
                              justifyContent: "center",
                              cursor: "pointer",
                            }}
                          >
                            ×
                          </button>
                        </div>
                      ))}
                    </div>
                  )}
                </div>

                {/* YouTube Video URL */}
                <div style={{ marginBottom: "18px" }}>
                  <label
                    style={{
                      display: "block",
                      fontSize: "0.85rem",
                      fontWeight: 600,
                      color: "#444",
                      marginBottom: "6px",
                    }}
                  >
                    YouTube Video URL (Optional)
                  </label>
                  <input
                    type="url"
                    value={formYoutube}
                    onChange={(e) => setFormYoutube(e.target.value)}
                    placeholder="https://youtube.com/watch?v=..."
                    style={{
                      width: "100%",
                      padding: "10px 14px",
                      borderRadius: "10px",
                      border: "1px solid #dcd3c5",
                      outline: "none",
                      fontSize: "0.9rem",
                    }}
                  />
                </div>

                {/* Name & Email Row */}
                <div
                  style={{
                    display: "grid",
                    gridTemplateColumns: "1fr 1fr",
                    gap: "14px",
                    marginBottom: "26px",
                  }}
                >
                  <div>
                    <label
                      style={{
                        display: "block",
                        fontSize: "0.85rem",
                        fontWeight: 600,
                        color: "#444",
                        marginBottom: "6px",
                      }}
                    >
                      Display Name *
                    </label>
                    <input
                      type="text"
                      required
                      value={formName}
                      onChange={(e) => setFormName(e.target.value)}
                      placeholder="e.g. Swetha Reddy"
                      style={{
                        width: "100%",
                        padding: "10px 14px",
                        borderRadius: "10px",
                        border: "1px solid #dcd3c5",
                        outline: "none",
                        fontSize: "0.9rem",
                      }}
                    />
                  </div>
                  <div>
                    <label
                      style={{
                        display: "block",
                        fontSize: "0.85rem",
                        fontWeight: 600,
                        color: "#444",
                        marginBottom: "6px",
                      }}
                    >
                      Email Address *
                    </label>
                    <input
                      type="email"
                      required
                      value={formEmail}
                      onChange={(e) => setFormEmail(e.target.value)}
                      placeholder="swetha@example.com"
                      style={{
                        width: "100%",
                        padding: "10px 14px",
                        borderRadius: "10px",
                        border: "1px solid #dcd3c5",
                        outline: "none",
                        fontSize: "0.9rem",
                      }}
                    />
                  </div>
                </div>

                {/* Submit button */}
                <button
                  type="submit"
                  disabled={isSubmitting}
                  style={{
                    width: "100%",
                    background: "linear-gradient(135deg, #2b2b2b 0%, #111 100%)",
                    color: "#fff",
                    border: "none",
                    borderRadius: "30px",
                    padding: "14px",
                    fontSize: "1rem",
                    fontWeight: 700,
                    cursor: "pointer",
                    boxShadow: "0 6px 18px rgba(0,0,0,0.15)",
                    transition: "all 0.2s",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    gap: "8px",
                  }}
                >
                  {isSubmitting ? "Submitting Review..." : "Publish Review"}
                </button>
              </form>
            )}
          </div>
        </div>
      )}

      {/* ══════════ LIGHTBOX MODAL ══════════ */}
      {lightboxImg && (
        <div
          onClick={() => setLightboxImg(null)}
          style={{
            position: "fixed",
            inset: 0,
            background: "rgba(0,0,0,0.85)",
            backdropFilter: "blur(8px)",
            zIndex: 10001,
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            padding: "30px",
          }}
        >
          <div style={{ position: "relative", maxWidth: "800px", maxHeight: "85vh" }}>
            <img
              src={lightboxImg}
              alt="Enlarged review photo"
              style={{
                width: "100%",
                height: "auto",
                maxHeight: "85vh",
                borderRadius: "16px",
                objectFit: "contain",
                boxShadow: "0 20px 50px rgba(0,0,0,0.5)",
              }}
            />
            <button
              onClick={() => setLightboxImg(null)}
              style={{
                position: "absolute",
                top: "-15px",
                right: "-15px",
                background: "#fff",
                border: "none",
                borderRadius: "50%",
                width: "36px",
                height: "36px",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                cursor: "pointer",
                boxShadow: "0 4px 12px rgba(0,0,0,0.2)",
              }}
            >
              <X size={20} color="#222" />
            </button>
          </div>
        </div>
      )}
    </SharedLayout>
  );
}
