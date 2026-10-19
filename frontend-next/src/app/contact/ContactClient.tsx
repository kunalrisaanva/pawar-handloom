"use client";

import React, { useState } from "react";
import Link from "next/link";
import SharedLayout from "@/components/SharedLayout";
import {
  Phone,
  Mail,
  MapPin,
  Clock,
  Send,
  CheckCircle2,
  AlertCircle,
  Loader2,
  ExternalLink,
  ChevronRight,
  MessageSquare,
  User,
} from "lucide-react";
import { FaWhatsapp } from "react-icons/fa";

export default function ContactClient() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    subject_type: "General Inquiry",
    custom_subject: "",
    message: "",
  });

  const [loading, setLoading] = useState(false);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>
  ) => {
    setFormData((prev) => ({
      ...prev,
      [e.target.name]: e.target.value,
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setErrorMessage(null);
    setSuccessMessage(null);

    const name = formData.name.trim();
    const email = formData.email.trim();
    const message = formData.message.trim();
    const subject =
      formData.subject_type === "Other" && formData.custom_subject.trim()
        ? formData.custom_subject.trim()
        : formData.subject_type;

    if (!name || name.length < 2) {
      setErrorMessage("Please enter your name.");
      return;
    }

    if (!email || !email.includes("@")) {
      setErrorMessage("Please enter a valid email address.");
      return;
    }

    if (!message || message.length < 5) {
      setErrorMessage("Please write a message of at least 5 characters.");
      return;
    }

    setLoading(true);

    try {
      const res = await fetch("/api/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name,
          email,
          subject_type: subject,
          message,
        }),
      });

      const data = await res.json();

      if (res.ok && data.status === "success") {
        setSuccessMessage(
          data.message ||
            "Thank you! Your message has been sent successfully. We will get in touch with you shortly."
        );
        setFormData({
          name: "",
          email: "",
          subject_type: "General Inquiry",
          custom_subject: "",
          message: "",
        });
      } else {
        setErrorMessage(
          data.message || "Failed to submit your message. Please try again."
        );
      }
    } catch (err: any) {
      console.error("Submission error:", err);
      setErrorMessage(
        "Could not connect to the server. Please check your network and try again."
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <SharedLayout>
      <div className="contact-page-wrapper">
        <style>{`
          .contact-page-wrapper {
            background-color: #fcfbfa;
            color: #222;
            font-family: "Outfit", sans-serif;
            min-height: 100vh;
          }

          /* Breadcrumb */
          .contact-breadcrumb-section {
            background: #f7eedf;
            border-bottom: 1px solid #ebd9c3;
            padding: 14px 20px;
          }
          .contact-breadcrumb {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #666;
          }
          .contact-breadcrumb a {
            color: #ac4024;
            text-decoration: none;
            font-weight: 500;
          }
          .contact-breadcrumb a:hover {
            text-decoration: underline;
          }

          /* Hero Section */
          .contact-hero {
            background: linear-gradient(135deg, #1c1917 0%, #292524 100%);
            color: #fff;
            padding: 60px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
          }
          .contact-hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at center, rgba(172, 64, 36, 0.25) 0%, transparent 70%);
            pointer-events: none;
          }
          .contact-hero-content {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            z-index: 1;
          }
          .contact-hero-tag {
            display: inline-block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #f7eedf;
            background: rgba(172, 64, 36, 0.4);
            border: 1px solid rgba(247, 238, 223, 0.2);
            padding: 5px 16px;
            border-radius: 20px;
            margin-bottom: 14px;
            font-weight: 600;
          }
          .contact-hero-title {
            font-size: 38px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 12px;
            color: #fff;
            text-transform: uppercase;
          }
          .contact-hero-subtitle {
            font-size: 16px;
            color: #d6d3d1;
            line-height: 1.6;
            margin: 0;
          }

          /* Main Container */
          .contact-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 50px 20px 80px;
          }

          /* Feature Cards */
          .contact-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 50px;
          }
          .contact-feature-card {
            background: #ffffff;
            border: 1px solid #ebd9c3;
            border-radius: 16px;
            padding: 30px 24px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
          }
          .contact-feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(172, 64, 36, 0.09);
            border-color: #ac4024;
          }
          .feature-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #f7eedf;
            color: #ac4024;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
          }
          .feature-text h4 {
            font-size: 18px;
            font-weight: 700;
            color: #1c1917;
            margin: 0 0 8px 0;
          }
          .feature-text p, .feature-text small {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin: 0;
            display: block;
          }
          .feature-text a {
            color: #ac4024;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
          }
          .feature-text a:hover {
            color: #8f331b;
            text-decoration: underline;
          }
          .feature-action-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #25d366 !important;
          }

          /* Two-Column Form & Map Layout */
          .contact-main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 36px;
            align-items: stretch;
          }
          @media (max-width: 900px) {
            .contact-main-grid {
              grid-template-columns: 1fr;
            }
          }

          /* Form Panel */
          .contact-form-panel {
            background: #ffffff;
            border: 1px solid #ebd9c3;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
          }
          .form-header-title {
            font-size: 26px;
            font-weight: 700;
            color: #1c1917;
            margin: 0 0 8px 0;
          }
          .form-header-desc {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin: 0 0 24px 0;
          }

          /* Form Alert Banners */
          .contact-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 22px;
          }
          .contact-alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
          }
          .contact-alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
          }

          /* Form Inputs */
          .contact-form-group {
            margin-bottom: 20px;
          }
          .contact-form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
          }
          .contact-form-label span.req {
            color: #ac4024;
            margin-left: 3px;
          }
          .contact-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
          }
          .contact-input-icon {
            position: absolute;
            left: 14px;
            color: #888;
            pointer-events: none;
          }
          .contact-form-input, .contact-form-select, .contact-form-textarea {
            width: 100%;
            background: #faf8f5;
            border: 1.5px solid #ebd9c3;
            border-radius: 10px;
            padding: 12px 14px 12px 42px;
            font-family: "Outfit", sans-serif;
            font-size: 14px;
            color: #222;
            transition: all 0.2s ease;
            outline: none;
            box-sizing: border-box;
          }
          .contact-form-textarea {
            padding: 12px 14px;
            resize: vertical;
            min-height: 120px;
          }
          .contact-form-select {
            padding-left: 14px;
            cursor: pointer;
          }
          .contact-form-input:focus, .contact-form-select:focus, .contact-form-textarea:focus {
            background: #ffffff;
            border-color: #ac4024;
            box-shadow: 0 0 0 3px rgba(172, 64, 36, 0.12);
          }

          /* Submit Button */
          .contact-submit-btn {
            background: #ac4024;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px 28px;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 12px rgba(172, 64, 36, 0.25);
          }
          .contact-submit-btn:hover:not(:disabled) {
            background: #8f331b;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(172, 64, 36, 0.35);
          }
          .contact-submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
          }

          /* Map Panel */
          .contact-map-panel {
            background: #ffffff;
            border: 1px solid #ebd9c3;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
          }
          .contact-map-frame-wrapper {
            position: relative;
            flex: 1;
            min-height: 380px;
            background: #eee;
          }
          .contact-map-frame-wrapper iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
          }
          .contact-map-footer {
            padding: 24px;
            background: #faf8f5;
            border-top: 1px solid #ebd9c3;
            display: flex;
            flex-direction: column;
            gap: 14px;
          }
          .map-footer-detail {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            color: #555;
            line-height: 1.5;
          }
          .map-footer-icon {
            color: #ac4024;
            flex-shrink: 0;
            margin-top: 2px;
          }
          .map-directions-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #1c1917;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s ease;
          }
          .map-directions-btn:hover {
            background: #ac4024;
          }
        `}</style>

        {/* Breadcrumb Bar */}
        <div className="contact-breadcrumb-section">
          <div className="contact-breadcrumb">
            <Link href="/">Home</Link>
            <ChevronRight size={14} />
            <span>Contact Us</span>
          </div>
        </div>

        {/* Hero Header */}
        <section className="contact-hero">
          <div className="contact-hero-content">
            <span className="contact-hero-tag">Reach Our Weavers & Support</span>
            <h1 className="contact-hero-title">Contact Pawar Handloom</h1>
            <p className="contact-hero-subtitle">
              Have a question about our authentic Maheshwari & Chanderi sarees, bulk wholesale orders, reseller accounts, or custom weaves? We are here to assist you.
            </p>
          </div>
        </section>

        {/* Content Container */}
        <main className="contact-container">
          {/* 3 Site Features */}
          <section className="contact-features-grid">
            {/* Phone & WhatsApp */}
            <div className="contact-feature-card">
              <div className="feature-icon-box">
                <Phone size={24} />
              </div>
              <div className="feature-text">
                <h4>Call or WhatsApp Us</h4>
                <p>
                  <a href="tel:+919630504663">+91 9630504663</a>
                  <br />
                  <a href="tel:+919039119245">+91 9039119245</a>
                </p>
                <small style={{ marginTop: "4px", color: "#888" }}>
                  Mon - Sun: 10:00 AM – 8:30 PM
                </small>
                <div>
                  <a
                    href="https://wa.me/919630504663?text=Hello%20Pawar%20Handloom,%20I%20have%20an%20inquiry."
                    target="_blank"
                    rel="noopener noreferrer"
                    className="feature-action-link"
                  >
                    <FaWhatsapp size={16} /> Chat on WhatsApp
                  </a>
                </div>
              </div>
            </div>

            {/* Email */}
            <div className="contact-feature-card">
              <div className="feature-icon-box">
                <Mail size={24} />
              </div>
              <div className="feature-text">
                <h4>E-Mail Us</h4>
                <p>
                  <a href="mailto:info@pawarhandloom.com">info@pawarhandloom.com</a>
                </p>
                <small style={{ marginTop: "6px", color: "#666" }}>
                  Direct inquiries regarding orders, products, and partner distribution.
                </small>
                <small style={{ color: "#ac4024", fontWeight: 500, marginTop: "4px" }}>
                  Replies within 24 hours
                </small>
              </div>
            </div>

            {/* Store Address */}
            <div className="contact-feature-card">
              <div className="feature-icon-box">
                <MapPin size={24} />
              </div>
              <div className="feature-text">
                <h4>Our Indore Showroom</h4>
                <p>
                  97-B, Ground Floor, Rishi Apartment, Rajendra Nagar, Indore, Madhya Pradesh 452012
                </p>
                <small style={{ marginTop: "6px", color: "#666" }}>
                  Authentic Handloom Saree Manufacturers & Wholesalers.
                </small>
              </div>
            </div>
          </section>

          {/* Form & Map Grid */}
          <section className="contact-main-grid">
            {/* Left: Contact Form */}
            <div className="contact-form-panel">
              <div>
                <h2 className="form-header-title">Drop Us a Line</h2>
                <p className="form-header-desc">
                  Fill in your details below and our team will get in touch with you promptly.
                </p>

                {/* Alerts */}
                {successMessage && (
                  <div className="contact-alert contact-alert-success">
                    <CheckCircle2 size={20} style={{ flexShrink: 0, marginTop: "1px" }} />
                    <div>{successMessage}</div>
                  </div>
                )}

                {errorMessage && (
                  <div className="contact-alert contact-alert-error">
                    <AlertCircle size={20} style={{ flexShrink: 0, marginTop: "1px" }} />
                    <div>{errorMessage}</div>
                  </div>
                )}

                <form onSubmit={handleSubmit}>
                  {/* Name */}
                  <div className="contact-form-group">
                    <label className="contact-form-label">
                      Your Name <span className="req">*</span>
                    </label>
                    <div className="contact-input-wrapper">
                      <User size={18} className="contact-input-icon" />
                      <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        placeholder="Enter your full name"
                        className="contact-form-input"
                        required
                      />
                    </div>
                  </div>

                  {/* Email */}
                  <div className="contact-form-group">
                    <label className="contact-form-label">
                      Your Email <span className="req">*</span>
                    </label>
                    <div className="contact-input-wrapper">
                      <Mail size={18} className="contact-input-icon" />
                      <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        placeholder="you@example.com"
                        className="contact-form-input"
                        required
                      />
                    </div>
                  </div>

                  {/* Subject Type Dropdown */}
                  <div className="contact-form-group">
                    <label className="contact-form-label">
                      Subject / Query Type
                    </label>
                    <select
                      name="subject_type"
                      value={formData.subject_type}
                      onChange={handleChange}
                      className="contact-form-select"
                    >
                      <option value="General Inquiry">General Inquiry</option>
                      <option value="Wholesale & Bulk Orders">Wholesale & Bulk Orders</option>
                      <option value="Reseller Account Activation">Reseller Account Activation</option>
                      <option value="Custom Saree Weaving">Custom Saree Weaving</option>
                      <option value="Order Status & Delivery">Order Status & Delivery</option>
                      <option value="Other">Other Reason...</option>
                    </select>
                  </div>

                  {/* Conditional Custom Subject Field */}
                  {formData.subject_type === "Other" && (
                    <div className="contact-form-group">
                      <label className="contact-form-label">Specify Subject</label>
                      <input
                        type="text"
                        name="custom_subject"
                        value={formData.custom_subject}
                        onChange={handleChange}
                        placeholder="Please specify your query subject"
                        className="contact-form-input"
                        style={{ paddingLeft: "14px" }}
                      />
                    </div>
                  )}

                  {/* Message */}
                  <div className="contact-form-group">
                    <label className="contact-form-label">
                      Your Message <span className="req">*</span>
                    </label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      placeholder="Please write your inquiry or requirement details here..."
                      className="contact-form-textarea"
                      required
                    ></textarea>
                  </div>

                  {/* Submit Button */}
                  <button
                    type="submit"
                    disabled={loading}
                    className="contact-submit-btn"
                  >
                    {loading ? (
                      <>
                        <Loader2 size={18} className="animate-spin" />
                        Sending Message...
                      </>
                    ) : (
                      <>
                        <Send size={18} />
                        Send Message
                      </>
                    )}
                  </button>
                </form>
              </div>
            </div>

            {/* Right: Google Maps Embed & Location Details */}
            <div className="contact-map-panel">
              <div className="contact-map-frame-wrapper">
                <iframe
                  title="Pawar Handloom Location"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3681.6422356717367!2d75.8263688!3d22.6671239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fdd9f5dc3c01%3A0x50740ede54c4e5cf!2sPAWAR%20HANDLOOM%20(Maheshwari%20%26%20Chanderi%20Saree%20Mfrs.%20%26%20Wholesaler)!5e0!3m2!1sen!2sin!4v1735201591655!5m2!1sen!2sin"
                  allowFullScreen
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                ></iframe>
              </div>

              <div className="contact-map-footer">
                <div className="map-footer-detail">
                  <MapPin size={18} className="map-footer-icon" />
                  <div>
                    <strong>Pawar Handloom</strong>
                    <br />
                    97-B, Ground Floor, Rishi Apartment, Rajendra Nagar, Indore, Madhya Pradesh 452012
                  </div>
                </div>

                <div className="map-footer-detail">
                  <Clock size={18} className="map-footer-icon" />
                  <div>
                    <strong>Store Visiting Hours:</strong>
                    <br />
                    Monday – Sunday: 10:00 AM – 8:30 PM
                  </div>
                </div>

                <a
                  href="https://maps.google.com/?cid=5797302482322318799"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="map-directions-btn"
                >
                  <ExternalLink size={16} />
                  Get Directions on Google Maps
                </a>
              </div>
            </div>
          </section>
        </main>
      </div>
    </SharedLayout>
  );
}
