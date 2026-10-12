"use client";
import { useState, useEffect } from "react";
import { ArrowLeft } from "lucide-react";

export default function CheckoutClient() {
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
    return (
      <div style={{ display: "flex", justifyContent: "center", alignItems: "center", minHeight: "50vh", fontFamily: "var(--font-sans)" }}>
        <p>Loading checkout...</p>
      </div>
    );
  }

  if (!cart || !cart.items || cart.items.length === 0) {
    return (
      <div style={{ textAlign: "center", padding: "60px 20px", fontFamily: "var(--font-sans)" }}>
        <h2>Your Cart is Empty</h2>
        <p>You need items in your cart to checkout.</p>
        <a href="/" style={{ color: "#a83d22", textDecoration: "underline" }}>Return to Shop</a>
      </div>
    );
  }

  return (
    <>
      <style>{`
        .checkout-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 40px 20px;
          font-family: var(--font-sans);
        }
        .checkout-header {
          display: flex;
          align-items: center;
          gap: 16px;
          margin-bottom: 40px;
        }
        .checkout-header a {
          display: flex;
          align-items: center;
          color: #a83d22;
          text-decoration: none;
          font-weight: 500;
        }
        .checkout-title {
          font-family: 'DM Serif Display', serif;
          font-size: 40px;
          color: #333;
          margin: 0;
        }
        .checkout-layout {
          display: grid;
          grid-template-columns: 2fr 1fr;
          gap: 40px;
          align-items: start;
        }
        @media (max-width: 900px) {
          .checkout-layout {
            grid-template-columns: 1fr;
          }
        }
        .checkout-card {
          background: #fff;
          border: 1px solid #ede3c9;
          padding: 32px;
          border-radius: 16px;
        }
        .checkout-card h2 {
          font-family: 'DM Serif Display', serif;
          font-size: 24px;
          margin-top: 0;
          margin-bottom: 24px;
          border-bottom: 1px solid #ede3c9;
          padding-bottom: 16px;
        }
        .form-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 24px;
        }
        .form-group {
          display: flex;
          flex-direction: column;
          gap: 8px;
        }
        .form-group.full {
          grid-column: 1 / -1;
        }
        .form-group label {
          font-size: 14px;
          font-weight: 500;
          color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
          padding: 12px 16px;
          border: 1px solid #ccc;
          border-radius: 8px;
          font-family: inherit;
          font-size: 16px;
        }
        .form-group textarea {
          resize: vertical;
          min-height: 100px;
        }
        .order-summary-item {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 12px 0;
          border-bottom: 1px dashed #eee;
        }
        .order-summary-item:last-child {
          border-bottom: none;
        }
        .order-summary-total {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding-top: 24px;
          margin-top: 16px;
          border-top: 1px solid #ede3c9;
          font-family: 'DM Serif Display', serif;
          font-size: 24px;
        }
        .place-order-btn {
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
          margin-top: 32px;
        }
        .place-order-btn:hover {
          background: #8a2f17;
        }
      `}</style>
      
      <div className="checkout-container">
        <div className="checkout-header">
          <a href="/cart"><ArrowLeft size={20} /> Back to Cart</a>
          <h1 className="checkout-title">Checkout</h1>
        </div>

        <form action="http://localhost:8080/checkout/placeOrder" method="POST">
          <div className="checkout-layout">
            <div className="checkout-card">
              <h2>Shipping Address</h2>
              <div className="form-grid">
                <div className="form-group">
                  <label>First Name*</label>
                  <input type="text" name="first_name" placeholder="First Name" required />
                </div>
                <div className="form-group">
                  <label>Last Name*</label>
                  <input type="text" name="last_name" placeholder="Last Name" required />
                </div>
                <div className="form-group">
                  <label>Email*</label>
                  <input type="email" name="email" placeholder="Email Address" required />
                </div>
                <div className="form-group">
                  <label>Phone*</label>
                  <input type="text" name="phone" placeholder="Phone Number" required />
                </div>
                <div className="form-group full">
                  <label>Company Name (Optional)</label>
                  <input type="text" name="company_name" placeholder="Company Name" />
                </div>
                <div className="form-group full">
                  <label>Street Address*</label>
                  <input type="text" name="address" placeholder="House no, Street name" required />
                </div>
                <div className="form-group">
                  <label>City*</label>
                  <input type="text" name="city" placeholder="City" required />
                </div>
                <div className="form-group">
                  <label>State*</label>
                  <input type="text" name="state" placeholder="State" required />
                </div>
                <div className="form-group">
                  <label>Zip Code*</label>
                  <input type="text" name="zipcode" placeholder="Postal Code" required />
                </div>
                <div className="form-group">
                  <label>Country*</label>
                  <select name="country" required>
                    <option value="India">India</option>
                    <option value="United States">United States</option>
                    <option value="United Kingdom">United Kingdom</option>
                  </select>
                </div>
                <div className="form-group full">
                  <label>Additional Notes</label>
                  <textarea name="notes" placeholder="Delivery instructions (optional)"></textarea>
                </div>
              </div>
            </div>

            <div className="checkout-card">
              <h2>Order Summary</h2>
              <div className="order-items-list">
                {cart.items.map((item: any, idx: number) => (
                  <div key={idx} className="order-summary-item">
                    <div>
                      <div style={{ fontWeight: 500 }}>{item.product_name}</div>
                      <div style={{ fontSize: "14px", color: "#666" }}>Qty: {item.qty}</div>
                    </div>
                    <div>₹{item.offer_price * item.qty}</div>
                  </div>
                ))}
              </div>

              <div className="order-summary-total">
                <span>Total</span>
                <span style={{ color: "#a83d22" }}>₹{cart.subTotal}</span>
              </div>

              <button type="submit" className="place-order-btn">Place Order</button>
            </div>
          </div>
        </form>
      </div>
    </>
  );
}
