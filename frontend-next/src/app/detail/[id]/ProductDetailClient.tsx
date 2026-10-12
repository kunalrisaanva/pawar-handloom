"use client";
import { useState } from "react";
import {
  ArrowLeft,
  ShoppingBag,
  Truck,
  ShieldCheck,
  Heart,
  Share2,
} from "lucide-react";

export default function ProductDetailClient({
  product,
  relatedProducts = [],
}: {
  product: any;
  relatedProducts?: any[];
}) {
  const [qty, setQty] = useState(1);
  const [adding, setAdding] = useState(false);

  const coverImage = product.cover_image
    ? "http://localhost:8080/" + product.cover_image
    : "/placeholder.png";

  const addToCart = async () => {
    setAdding(true);
    try {
      const formData = new FormData();
      formData.append("id", product.id.toString());
      formData.append("product_name", product.product_name);
      formData.append("offer_price", product.offer_price.toString());
      formData.append("qty", qty.toString());
      formData.append("image", coverImage);
      formData.append("color", "");

      const res = await fetch("http://localhost:8080/cart/add", {
        method: "POST",
        body: formData,
        credentials: "include",
      });

      const data = await res.json();
      if (data.status === "success") {
        window.dispatchEvent(new Event("cart-updated"));
        alert("Added to cart!");
      } else {
        alert(data.message || "Failed to add to cart");
      }
    } catch (e) {
      console.error(e);
      alert("Error adding to cart");
    } finally {
      setAdding(false);
    }
  };

  return (
    <>
      <style>{`
        .product-detail-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 40px 20px;
          font-family: var(--font-sans);
        }
        .breadcrumb {
          margin-bottom: 24px;
        }
        .breadcrumb a {
          color: #a83d22;
          text-decoration: none;
          display: inline-flex;
          align-items: center;
          gap: 8px;
          font-weight: 500;
        }
        .detail-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 60px;
        }
        @media (max-width: 900px) {
          .detail-grid {
            grid-template-columns: 1fr;
            gap: 40px;
          }
        }
        .product-gallery {
          background: #f9f9f9;
          border-radius: 16px;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        .product-gallery img {
          width: 100%;
          height: auto;
          object-fit: cover;
        }
        .product-info h1 {
          font-family: 'DM Serif Display', serif;
          font-size: 36px;
          color: #333;
          margin-top: 0;
          margin-bottom: 16px;
        }
        .price-row {
          display: flex;
          align-items: center;
          gap: 16px;
          margin-bottom: 24px;
        }
        .sale-price {
          font-size: 28px;
          color: #a83d22;
          font-weight: 600;
        }
        .original-price {
          font-size: 20px;
          color: #999;
          text-decoration: line-through;
        }
        .qty-selector {
          display: inline-flex;
          align-items: center;
          border: 1px solid #ccc;
          border-radius: 30px;
          overflow: hidden;
          margin-bottom: 24px;
        }
        .qty-btn {
          background: none;
          border: none;
          padding: 12px 20px;
          font-size: 18px;
          cursor: pointer;
        }
        .qty-btn:hover {
          background: #f1f1f1;
        }
        .qty-val {
          padding: 0 20px;
          font-weight: 500;
          font-size: 18px;
        }
        .action-row {
          display: flex;
          gap: 16px;
          margin-bottom: 32px;
        }
        .add-to-cart-btn {
          flex: 1;
          background: #a83d22;
          color: white;
          border: none;
          padding: 16px;
          border-radius: 30px;
          font-size: 18px;
          font-weight: 500;
          cursor: pointer;
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 8px;
          transition: background 0.2s;
        }
        .add-to-cart-btn:hover {
          background: #8a2f17;
        }
        .icon-btn {
          width: 56px;
          height: 56px;
          display: flex;
          align-items: center;
          justify-content: center;
          border: 1px solid #ccc;
          border-radius: 50%;
          background: white;
          cursor: pointer;
          transition: background 0.2s;
        }
        .icon-btn:hover {
          background: #f9f9f9;
        }
        .product-description {
          line-height: 1.6;
          color: #555;
          margin-bottom: 32px;
        }
        .features {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 16px;
          margin-top: 32px;
          border-top: 1px solid #eee;
          padding-top: 24px;
        }
        .feature-item {
          display: flex;
          align-items: center;
          gap: 12px;
          color: #444;
          font-weight: 500;
        }
        .related-products-section {
          margin-top: 80px;
          padding-top: 40px;
          border-top: 1px solid #ede3c9;
        }
        .related-title {
          font-family: 'DM Serif Display', serif;
          font-size: 32px;
          text-align: center;
          margin-bottom: 40px;
          color: #333;
        }
        .related-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 24px;
        }
        @media (max-width: 1024px) {
          .related-grid {
            grid-template-columns: repeat(2, 1fr);
          }
        }
        @media (max-width: 600px) {
          .related-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
          }
        }
        .product-card {
          border-radius: 12px;
          overflow: hidden;
          background: #fff;
          transition: transform 0.3s;
          display: block;
          text-decoration: none;
          color: inherit;
        }
        .product-card:hover {
          transform: translateY(-5px);
        }
        .product-img-wrapper {
          position: relative;
          aspect-ratio: 3/4;
          background: #f4f4f4;
          overflow: hidden;
        }
        .product-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.5s ease;
        }
        .product-card:hover .product-img {
          transform: scale(1.05);
        }
        .product-info-sm {
          padding: 16px 12px;
          text-align: center;
        }
        .product-name-sm {
          font-size: 16px;
          color: #333;
          margin-bottom: 8px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }
        .product-price-sm {
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 8px;
        }
        .sale-price-sm {
          color: #a83d22;
          font-weight: 600;
          font-size: 16px;
        }
        .original-price-sm {
          color: #999;
          text-decoration: line-through;
          font-size: 14px;
        }
      `}</style>

      <div className="product-detail-container">
        <div className="breadcrumb">
          <a href="/">
            <ArrowLeft size={16} /> Back to Shop
          </a>
        </div>

        <div className="detail-grid">
          {/* Gallery Side */}
          <div className="product-gallery">
            <img src={coverImage} alt={product.product_name} />
          </div>

          {/* Info Side */}
          <div className="product-info">
            <h1>{product.product_name}</h1>

            <div className="price-row">
              <span className="sale-price">₹{product.offer_price}</span>
              {product.actual_price &&
                product.actual_price > product.offer_price && (
                  <span className="original-price">
                    ₹{product.actual_price}
                  </span>
                )}
            </div>

            <div
              className="product-description"
              dangerouslySetInnerHTML={{
                __html: product.short_description || product.description || "",
              }}
            />

            <div>
              <div style={{ marginBottom: "8px", fontWeight: 500 }}>
                Quantity
              </div>
              <div className="qty-selector">
                <button
                  className="qty-btn"
                  onClick={() => setQty(Math.max(1, qty - 1))}
                >
                  -
                </button>
                <div className="qty-val">{qty}</div>
                <button className="qty-btn" onClick={() => setQty(qty + 1)}>
                  +
                </button>
              </div>
            </div>

            <div className="action-row">
              <button
                className="add-to-cart-btn"
                onClick={addToCart}
                disabled={adding}
              >
                <ShoppingBag size={20} />
                {adding ? "Adding..." : "Add to Cart"}
              </button>
              <button className="icon-btn">
                <Heart size={20} />
              </button>
              <button className="icon-btn">
                <Share2 size={20} />
              </button>
            </div>

            <div className="features">
              <div className="feature-item">
                <Truck size={24} color="#a83d22" />
                <span>Fast & Reliable Delivery</span>
              </div>
              <div className="feature-item">
                <ShieldCheck size={24} color="#a83d22" />
                <span>Secure Payments</span>
              </div>
            </div>
          </div>
        </div>

        {relatedProducts && relatedProducts.length > 0 && (
          <div className="related-products-section">
            <h2 className="related-title">You May Also Like</h2>
            <div className="related-grid">
              {relatedProducts.map((p, idx) => {
                const pImage = p.cover_image
                  ? "http://localhost:8080/" + p.cover_image
                  : "/placeholder.png";
                return (
                  <a
                    href={`/detail/${p.id}`}
                    key={idx}
                    className="product-card"
                  >
                    <div className="product-img-wrapper">
                      <img
                        src={pImage}
                        alt={p.product_name}
                        className="product-img"
                      />
                    </div>
                    <div className="product-info-sm">
                      <div className="product-name-sm">{p.product_name}</div>
                      <div className="product-price-sm">
                        <span className="sale-price-sm">₹{p.offer_price}</span>
                        {p.actual_price > p.offer_price && (
                          <span className="original-price-sm">
                            ₹{p.actual_price}
                          </span>
                        )}
                      </div>
                    </div>
                  </a>
                );
              })}
            </div>
          </div>
        )}
      </div>
    </>
  );
}
