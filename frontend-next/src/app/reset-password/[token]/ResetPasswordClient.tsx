"use client";

import React, { useState } from "react";
import SharedLayout from "@/components/SharedLayout";
import { Lock, CheckCircle2, AlertCircle, Loader2, ArrowRight } from "lucide-react";

export default function ResetPasswordClient({ token }: { token: string }) {
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setErrorMessage(null);

    if (password.length < 6) {
      setErrorMessage("Password must be at least 6 characters long.");
      return;
    }

    if (password !== confirmPassword) {
      setErrorMessage("Passwords do not match. Please re-enter.");
      return;
    }

    setLoading(true);

    try {
      const formData = new FormData();
      formData.append("password", password);
      formData.append("confirm_password", confirmPassword);

      const res = await fetch(`http://localhost:8080/reset-password/${token}`, {
        method: "POST",
        body: formData,
        credentials: "include",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      });

      const data = await res.json();

      if (data.status === "success") {
        setSuccess(true);
      } else {
        setErrorMessage(data.message || "Failed to reset password. The link may have expired.");
      }
    } catch (err) {
      console.error(err);
      setErrorMessage("Network error. Please try again later.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <SharedLayout>
      <div className="reset-password-page">
        <style>{`
          .reset-password-page {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            background-color: #fff;
            padding: 60px 20px;
          }
          .reset-password-card {
            background-color: #f7eedf;
            width: 100%;
            max-width: 540px;
            border-radius: 20px;
            padding: 50px 45px;
            box-sizing: border-box;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
          }
          .rp-title {
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #222;
            margin-bottom: 12px;
            text-transform: uppercase;
          }
          .rp-desc {
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
          }
          .rp-alert {
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
          .rp-alert-success {
            background: #eaf7ee;
            border: 1px solid #c3e6cb;
            color: #1e6935;
          }
          .rp-alert-error {
            background: #fde8e8;
            border: 1px solid #f8b4b4;
            color: #9b1c1c;
          }
          .rp-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
          }
          .rp-input-group {
            position: relative;
            display: flex;
            align-items: center;
          }
          .rp-input-icon {
            position: absolute;
            left: 16px;
            color: #888;
            pointer-events: none;
          }
          .rp-input {
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
          .rp-input:focus {
            border-color: #ac4024;
            box-shadow: 0 0 0 3px rgba(172, 64, 36, 0.12);
          }
          .rp-btn-submit {
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
            margin-top: 10px;
          }
          .rp-btn-submit:hover:not(:disabled) {
            background-color: #8a2f17;
          }
          .rp-btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
          }
          .rp-success-box {
            text-align: center;
            padding: 20px 0;
            font-family: "Outfit", sans-serif;
          }
          .rp-success-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #ac4024;
            color: #fff;
            padding: 14px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            margin-top: 20px;
            transition: background 0.2s;
          }
          .rp-success-btn:hover {
            background-color: #8a2f17;
          }
        `}</style>

        <div className="reset-password-card">
          <h1 className="rp-title">Create New Password</h1>

          {success ? (
            <div className="rp-success-box">
              <CheckCircle2 size={48} color="#2e7d32" style={{ margin: "0 auto 16px" }} />
              <h3 style={{ fontSize: 18, color: "#222", marginBottom: 8 }}>Password Reset Successfully!</h3>
              <p style={{ fontSize: 14, color: "#666", lineHeight: 1.6 }}>
                Your password has been securely updated. You can now log into your account using your new credentials.
              </p>
              <a href="/customer-login" className="rp-success-btn">
                <span>Proceed to Login</span>
                <ArrowRight size={16} />
              </a>
            </div>
          ) : (
            <>
              <p className="rp-desc">
                Please enter a new password for your account below.
              </p>

              {errorMessage && (
                <div className="rp-alert rp-alert-error">
                  <AlertCircle size={20} style={{ flexShrink: 0, marginTop: 1 }} />
                  <div>{errorMessage}</div>
                </div>
              )}

              <form className="rp-form" onSubmit={handleSubmit}>
                <div className="rp-input-group">
                  <Lock size={18} className="rp-input-icon" />
                  <input
                    type="password"
                    className="rp-input"
                    placeholder="New password (min. 6 characters)"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                    minLength={6}
                    disabled={loading}
                  />
                </div>

                <div className="rp-input-group">
                  <Lock size={18} className="rp-input-icon" />
                  <input
                    type="password"
                    className="rp-input"
                    placeholder="Confirm new password"
                    value={confirmPassword}
                    onChange={(e) => setConfirmPassword(e.target.value)}
                    required
                    minLength={6}
                    disabled={loading}
                  />
                </div>

                <button
                  type="submit"
                  className="rp-btn-submit"
                  disabled={loading || !password || !confirmPassword}
                >
                  {loading ? (
                    <>
                      <Loader2 size={18} className="animate-spin" />
                      <span>Updating Password...</span>
                    </>
                  ) : (
                    <span>Update Password</span>
                  )}
                </button>
              </form>
            </>
          )}
        </div>
      </div>
    </SharedLayout>
  );
}
