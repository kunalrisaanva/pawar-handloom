"use client";
import { useState, useEffect } from "react";
import { ShoppingCart, ArrowLeft, Trash2 } from "lucide-react";

export default function CartClient() {
  const [cart, setCart] = useState<any>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchCart();
  }, []);

  const fetchCart = async () => {
    try {
      const res = await fetch("http://localhost:8080/cart/api", {
        credentials: "include"
      });
      const data = await res.json();
      if (data.status === 'success') {
        setCart(data);
      }
    } catch (e) {
      console.error("Failed to fetch cart:", e);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return <div style={{ padding: "100px", textAlign: "center", color: "#888" }}>Loading your elegant choices...</div>;
  }

  return (
    <>
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Outfit:wght@300;400;500;600;700&display=swap');
        
        .cart-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 40px 20px;
          font-family: 'Outfit', sans-serif;
        }
        .cart-header {
          display: flex;
          align-items: center;
          gap: 16px;
          margin-bottom: 40px;
        }
        .cart-back-btn {
          color: #a83d22;
          text-decoration: none;
          display: flex;
          align-items: center;
          gap: 8px;
          font-size: 16px;
        }
        .cart-back-btn:hover {
          text-decoration: underline;
        }
        .cart-title {
          font-family: 'DM Serif Display', serif;
          font-size: 42px;
          color: #a83d22;
          margin: 0;
          font-weight: normal;
        }
        .cart-empty {
          text-align: center;
          padding: 80px 20px;
          background: #fbf9f4;
          border: 1px solid #ede3c9;
          border-radius: 16px;
        }
        .cart-empty h2 {
          font-family: 'DM Serif Display', serif;
          font-size: 28px;
          color: #a83d22;
          margin-bottom: 12px;
        }
        .cart-empty p {
          color: #666;
          margin-bottom: 30px;
          font-size: 18px;
        }
        .cart-empty-btn {
          display: inline-block;
          background: #a83d22;
          color: #fff;
          padding: 14px 40px;
          border-radius: 30px;
          text-decoration: none;
          font-size: 18px;
          transition: background 0.2s;
        }
        .cart-empty-btn:hover {
          background: #8a2f17;
        }
        .cart-layout {
          display: grid;
          grid-template-columns: 2fr 1fr;
          gap: 40px;
          align-items: start;
        }
        @media (max-width: 900px) {
          .cart-layout {
            grid-template-columns: 1fr;
          }
          .cart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
          }
          .cart-title {
            font-size: 32px;
            line-height: 1.2;
          }
          .cart-table {
            min-width: 100%;
          }
          .cart-table thead {
            display: none;
          }
          .cart-table tbody, .cart-table tr, .cart-table td {
            display: block;
            width: 100%;
          }
          .cart-table tr {
            position: relative;
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid #ede3c9;
          }
          .cart-table td {
            padding: 0;
            border: none;
          }
          .cart-product-cell {
            align-items: flex-start;
          }
          .cart-table td.center {
            text-align: left;
            padding-top: 16px;
            padding-left: 124px; /* Align with text next to image (100px width + 24px gap) */
          }
          .cart-table td.right {
            text-align: right;
            position: absolute;
            bottom: 24px;
            right: 0;
          }
          .cart-item-total {
            font-size: 18px;
          }
          .cart-remove-btn {
            margin-top: 8px;
            margin-left: auto;
          }
          .cart-summary {
            padding: 24px;
          }
        }
        .cart-table-wrapper {
          overflow-x: auto;
        }
        .cart-table {
          width: 100%;
          border-collapse: collapse;
          min-width: 600px;
        }
        .cart-table th {
          text-align: left;
          padding-bottom: 16px;
          border-bottom: 2px solid #ede3c9;
          color: #a83d22;
          font-family: "Outfit", sans-serif;
          font-size: 20px;
          font-weight: normal;
        }
        .cart-table th.center { text-align: center; }
        .cart-table th.right { text-align: right; }
        .cart-table td {
          padding: 30px 0;
          border-bottom: 1px solid #ede3c9;
        }
        .cart-product-cell {
          display: flex;
          align-items: center;
          gap: 24px;
        }
        .cart-product-img {
          width: 100px;
          height: 130px;
          object-fit: cover;
          border-radius: 8px;
          border: 1px solid #eee;
        }
        .cart-product-name {
          font-family: "Outfit", sans-serif;
          font-size: 20px;
          color: #333;
          margin: 0 0 8px 0;
        }
        .cart-product-price {
          color: #a83d22;
          font-weight: 500;
          font-size: 18px;
          margin: 0;
        }
        .cart-qty-badge {
          display: inline-block;
          background: #fff;
          border: 1px solid #ede3c9;
          padding: 8px 24px;
          border-radius: 8px;
          font-weight: 500;
        }
        .cart-total-cell {
          text-align: right;
        }
        .cart-item-total {
          font-weight: 600;
          font-size: 20px;
          color: #333;
          margin: 0;
        }
        .cart-remove-btn {
          background: none;
          border: none;
          color: #999;
          font-size: 14px;
          display: flex;
          align-items: center;
          gap: 4px;
          cursor: pointer;
          margin-top: 12px;
          margin-left: auto;
        }
        .cart-remove-btn:hover {
          color: #e53e3e;
        }
        .cart-summary {
          background: #fbf9f4;
          border: 1px solid #ede3c9;
          padding: 40px;
          border-radius: 16px;
        }
        .cart-summary h2 {
          font-family: 'DM Serif Display', serif;
          font-size: 28px;
          color: #a83d22;
          margin: 0 0 24px 0;
          padding-bottom: 16px;
          border-bottom: 1px solid #ede3c9;
          font-weight: normal;
        }
        .summary-row {
          display: flex;
          justify-content: space-between;
          margin-bottom: 20px;
          font-size: 18px;
          color: #555;
        }
        .summary-row.total {
          margin-top: 24px;
          padding-top: 24px;
          border-top: 1px solid #ede3c9;
          font-family: 'DM Serif Display', serif;
          font-size: 24px;
          color: #333;
        }
        .summary-row.total .price {
          color: #a83d22;
        }
        .checkout-btn {
          display: block;
          width: 100%;
          background: #a83d22;
          color: white;
          border: none;
          padding: 16px;
          border-radius: 30px;
          font-size: 18px;
          font-weight: 500;
          cursor: pointer;
          transition: background 0.2s;
          margin-top: 30px;
        }
        .checkout-btn:hover {
          background: #8a2f17;
        }
      `}</style>
      <div className="cart-container">
        <div className="cart-header">
          <a href="/" className="cart-back-btn">
            <ArrowLeft size={18} /> Continue Shopping
          </a>
          <h1 className="cart-title">Your Shopping Cart</h1>
        </div>

        {!cart?.items?.length ? (
          <div className="cart-empty">
            <ShoppingCart size={64} style={{ color: "#d4af37", opacity: 0.4, margin: "0 auto 20px auto", display: "block" }} />
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any exquisite handlooms yet.</p>
            <a href="/" className="cart-empty-btn">Explore Collection</a>
          </div>
        ) : (
          <div className="cart-layout">
            <div className="cart-table-wrapper">
              <table className="cart-table">
                <thead>
                  <tr>
                    <th>Product Details</th>
                    <th className="center">Quantity</th>
                    <th className="right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  {cart.items.map((item: any, idx: number) => (
                    <tr key={idx}>
                      <td>
                        <div className="cart-product-cell">
                          <img src={item.image} alt={item.product_name} className="cart-product-img" />
                          <div>
                            <h3 className="cart-product-name">{item.product_name}</h3>
                            <p className="cart-product-price">₹{item.offer_price}</p>
                            {item.color && (
                              <p style={{ color: "#777", fontSize: "14px", marginTop: "8px" }}>Color: <span style={{ color: "#333" }}>{item.color}</span></p>
                            )}
                          </div>
                        </div>
                      </td>
                      <td className="center">
                        <span className="cart-qty-badge">{item.qty}</span>
                      </td>
                      <td className="cart-total-cell">
                        <p className="cart-item-total">₹{parseInt(item.offer_price) * parseInt(item.qty)}</p>
                        <button className="cart-remove-btn">
                          <Trash2 size={14} /> Remove
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            <div className="cart-summary">
              <h2>Order Summary</h2>
              <div className="summary-row">
                <span>Subtotal ({cart.totalItems} items)</span>
                <span style={{ fontWeight: 600, color: "#333" }}>₹{cart.subTotal}</span>
              </div>
              <div className="summary-row">
                <span>Shipping Estimate</span>
                <span style={{ color: "#2f855a", fontWeight: 500 }}>Calculated at checkout</span>
              </div>
              <div className="summary-row total">
                <span>Total</span>
                <span className="price">₹{cart.subTotal}</span>
              </div>
              <button className="checkout-btn">Secure Checkout</button>
              <div style={{ textAlign: "center", fontSize: "14px", color: "#888", marginTop: "16px" }}>
                Taxes included. Shipping calculated at checkout.
              </div>
            </div>
          </div>
        )}
      </div>
    </>
  );
}
