"use client";
import React, { useState } from "react";
import SharedLayout from "@/components/SharedLayout";

export default function CustomerLoginClient() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      const formData = new FormData();
      formData.append("email", email);
      formData.append("password", password);
      // The old site uses /CustomerLogin for GET, maybe POST too. Adjust as needed!

      const res = await fetch("http://localhost:8080/CustomerLogin", {
        method: "POST",
        body: formData,
        credentials: "include"
      });
      const data = await res.json();
      
      if (data.status === "success" || res.ok) {
        window.location.href = "/";
      } else {
        alert(data.message || "Login failed");
      }
    } catch (e) {
      console.error(e);
      alert("Login attempt submitted! Backend hookup needed if error persists.");
    }
  };

  return (
    <SharedLayout>
      <div className="login-page-container">
        <style>{`
          .login-page-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            background-color: #fff;
            padding: 60px 20px;
          }
          .login-box {
            background-color: #f7eedf;
            width: 100%;
            max-width: 550px;
            border-radius: 20px;
            padding: 60px 50px;
            box-sizing: border-box;
          }
          .login-title {
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 20px;
            font-weight: 500;
            letter-spacing: 1px;
            color: #333;
            margin-bottom: 40px;
          }
          .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
          }
          .login-input {
            width: 100%;
            padding: 14px 16px;
            background: transparent;
            border: 1px solid #d4c7b2;
            border-radius: 4px;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
            color: #333;
            outline: none;
            transition: border-color 0.2s;
          }
          .login-input::placeholder {
            color: #888;
          }
          .login-input:focus {
            border-color: #a83d22;
          }
          .login-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
          }
          .login-btn {
            background-color: #ac4024;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 4px;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
          }
          .login-btn:hover {
            background-color: #8a2f17;
          }
          .login-links {
            margin-top: 40px;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 16px;
            font-family: "Outfit", sans-serif;
            font-size: 14px;
          }
          .login-links a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
          }
          .login-links a:hover {
            color: #ac4024;
          }
          @media (max-width: 600px) {
            .login-box {
              padding: 40px 24px;
            }
          }
        `}</style>

        <div className="login-box">
          <div className="login-title">CUSTOMER LOGIN</div>
          
          <form className="login-form" onSubmit={handleLogin}>
            <input 
              type="email" 
              className="login-input" 
              placeholder="Email address" 
              value={email}
              onChange={e => setEmail(e.target.value)}
              required
            />
            <input 
              type="password" 
              className="login-input" 
              placeholder="Password" 
              value={password}
              onChange={e => setPassword(e.target.value)}
              required
            />
            
            <div className="login-btn-container">
              <button type="submit" className="login-btn">Log in</button>
            </div>
          </form>

          <div className="login-links">
            <a href="#">Lost your password?</a>
            <a href="/customer-register">Doesn't Have an Account? Sign Up Here</a>
          </div>
        </div>
      </div>
    </SharedLayout>
  );
}
