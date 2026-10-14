"use client";

import React, { useState } from "react";
import SharedLayout from "@/components/SharedLayout";
import { Mail, ArrowLeft, CheckCircle2, AlertCircle, Loader2 } from "lucide-react";

export default function LostPasswordClient() {
  const [email, setEmail] = useState("");
  const [loading, setLoading] = useState(false);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);
  const [devResetLink, setDevResetLink] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setErrorMessage(null);
    setSuccessMessage(null);
    setDevResetLink(null);
    setLoading(true);

    try {
      const res = await fetch("/api/auth/forgot-password", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email: email.trim() }),
      });

      const data = await res.json();

      if (data.status === "success") {
        setSuccessMessage(
          data.message ||
            "A password reset link has been sent to your email address. Please check your inbox and spam folder."
        );
        if (data.reset_link) {
          setDevResetLink(data.reset_link);
        }
      } else {
        setErrorMessage(
          data.message || "We could not find an account with that email address."
        );
      }
    } catch (err: any) {
      console.error(err);
      setErrorMessage(
        "Could not connect to the server. Please verify your connection and try again."
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <SharedLayout>
      <div className="lost-password-page">
        <style>{`
          .lost-password-page {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            background-color: #fff;
            padding: 60px 20px;
          }
          .lost-password-card {
            background-color: #f7eedf;
            width: 100%;
            max-width: 540px;
            border-radius: 20px;
            padding: 50px 45px;
            box-sizing: border-box;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
          }
          .lost-password-title {
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #222;
            margin-bottom: 12px;
            text-transform: uppercase;
          }
          .lost-password-desc {
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
          }
          .lp-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            font-family: "Outfit", sans-serif;
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 24px;
          }
          .lp-alert-success {
            background: #eaf7ee;
            border: 1px solid #c3e6cb;
            color: #1e6935;
          }
          .lp-alert-error {
            background: #fde8e8;
            border: 1px solid #f8b4b4;
            color: #9b1c1c;
          }
          .lp-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
          }
          .lp-input-group {
            position: relative;
            display: flex;
            align-items: center;
          }
          .lp-input-icon {
            position: absolute;
            left: 16px;
            color: #888;
            pointer-events: none;
          }
          .lp-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: #fff;
            border: 1px solid #d4c7b2;
            border-radius: 8px;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
            color: #222;
            outline: none;
            transition: all 0.2s ease;
          }
          .lp-input:focus {
            border-color: #ac4024;
            box-shadow: 0 0 0 3px rgba(172, 64, 36, 0.12);
          }
          .lp-btn-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
          }
          .lp-btn-submit {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            background-color: #ac4024;
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            width: 100%;
          }
          .lp-btn-submit:hover:not(:disabled) {
            background-color: #8a2f17;
          }
          .lp-btn-submit:active:not(:disabled) {
            transform: scale(0.99);
          }
          .lp-btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
          }
          .dev-link-box {
            background: #fff;
            border: 1px dashed #ac4024;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 15px;
            font-size: 12px;
            font-family: monospace;
            word-break: break-all;
          }
          .dev-link-box a {
            color: #ac4024;
            font-weight: 600;
            text-decoration: underline;
          }
          .lp-links {
            margin-top: 35px;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 14px;
            font-family: "Outfit", sans-serif;
            font-size: 14px;
          }
          .lp-links a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
          }
          .lp-links a:hover {
            color: #ac4024;
          }
          .lp-links a.lp-back-link {
            font-weight: 500;
            color: #ac4024;
          }
          @media (max-width: 600px) {
            .lost-password-card {
              padding: 35px 22px;
              border-radius: 16px;
            }
            .lost-password-title {
              font-size: 20px;
            }
          }
        `}</style>

        <div className="lost-password-card">
          <h1 className="lost-password-title">Lost Your Password?</h1>
          <p className="lost-password-desc">
            Please enter your registered email address below. We'll send you a
            secure link to reset your password.
          </p>

          {successMessage && (
            <div className="lp-alert lp-alert-success">
              <CheckCircle2 size={20} style={{ flexShrink: 0, marginTop: 1 }} />
              <div>
                <strong>Link Sent!</strong>
                <p style={{ marginTop: 4 }}>{successMessage}</p>
                {devResetLink && (
                  <div className="dev-link-box">
                    <span>Direct reset link for testing:</span>
                    <br />
                    <a href={devResetLink}>Open Password Reset Page &rarr;</a>
                  </div>
                )}
              </div>
            </div>
          )}

          {errorMessage && (
            <div className="lp-alert lp-alert-error">
              <AlertCircle size={20} style={{ flexShrink: 0, marginTop: 1 }} />
              <div>{errorMessage}</div>
            </div>
          )}

          <form className="lp-form" onSubmit={handleSubmit}>
            <div className="lp-input-group">
              <Mail size={18} className="lp-input-icon" />
              <input
                type="email"
                className="lp-input"
                placeholder="Enter your registered email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                autoFocus
                disabled={loading}
              />
            </div>

            <div className="lp-btn-container">
              <button
                type="submit"
                className="lp-btn-submit"
                disabled={loading || !email.trim()}
              >
                {loading ? (
                  <>
                    <Loader2 size={18} className="animate-spin" />
                    <span>Sending Reset Link...</span>
                  </>
                ) : (
                  <span>Reset Password</span>
                )}
              </button>
            </div>
          </form>

          <div className="lp-links">
            <a href="/customer-login" className="lp-back-link">
              <ArrowLeft size={16} />
              <span>Back to Customer Login</span>
            </a>
            <a href="/customer-register">
              Doesn't Have an Account? Sign Up Here
            </a>
          </div>
        </div>
      </div>
    </SharedLayout>
  );
}
