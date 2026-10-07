"use client";
import React, { useState } from "react";
import SharedLayout from "@/components/SharedLayout";

export default function CustomerRegisterClient() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    confirmPassword: ""
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (formData.password !== formData.confirmPassword) {
      alert("Passwords do not match!");
      return;
    }

    try {
      const data = new FormData();
      data.append("submitRegister", "1"); // As expected by HomeController.php
      data.append("name", formData.name);
      data.append("email", formData.email);
      data.append("password", formData.password);

      const res = await fetch("http://localhost:8080/CustomerRegister", {
        method: "POST",
        body: data,
        credentials: "include"
      });
      // The CodeIgniter backend might return an HTML page or redirect, 
      // so if it's OK, we can redirect manually if it doesn't do it for us.
      if (res.ok) {
        window.location.href = "/customer-login";
      } else {
        alert("Registration failed. Email might already exist.");
      }
    } catch (e) {
      console.error(e);
      alert("Registration submitted! Backend hookup needed if error persists.");
    }
  };

  return (
    <SharedLayout>
      <div className="register-page-container">
        <style>{`
          .register-page-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            background-color: #fff;
            padding: 60px 20px;
          }
          .register-box {
            background-color: #f7eedf;
            width: 100%;
            max-width: 600px;
            border-radius: 20px;
            padding: 60px 50px;
            box-sizing: border-box;
          }
          .register-title {
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 20px;
            font-weight: 500;
            letter-spacing: 1px;
            color: #333;
            margin-bottom: 40px;
            text-transform: uppercase;
          }
          .register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
          }
          .register-input {
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
          .register-input::placeholder {
            color: #777;
          }
          .register-input:focus {
            border-color: #a83d22;
          }
          .register-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
          }
          .register-btn {
            background-color: #ac4024;
            color: #fff;
            border: none;
            padding: 10px 40px;
            border-radius: 4px;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
          }
          .register-btn:hover {
            background-color: #8a2f17;
          }
          .register-links {
            margin-top: 40px;
            text-align: center;
            font-family: "Outfit", sans-serif;
            font-size: 15px;
          }
          .register-links a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
          }
          .register-links a:hover {
            color: #ac4024;
          }
          @media (max-width: 600px) {
            .register-box {
              padding: 40px 24px;
            }
          }
        `}</style>

        <div className="register-box">
          <div className="register-title">CUSTOMER REGISTRATION</div>
          
          <form className="register-form" onSubmit={handleRegister}>
            <input 
              type="text" 
              name="name"
              className="register-input" 
              placeholder="Full Name" 
              value={formData.name}
              onChange={handleChange}
              required
            />
            <input 
              type="email" 
              name="email"
              className="register-input" 
              placeholder="Email address" 
              value={formData.email}
              onChange={handleChange}
              required
            />
            <input 
              type="password" 
              name="password"
              className="register-input" 
              placeholder="Password" 
              value={formData.password}
              onChange={handleChange}
              required
            />
            <input 
              type="password" 
              name="confirmPassword"
              className="register-input" 
              placeholder="Retype Password" 
              value={formData.confirmPassword}
              onChange={handleChange}
              required
            />
            
            <div className="register-btn-container">
              <button type="submit" className="register-btn">Register</button>
            </div>
          </form>

          <div className="register-links">
            <a href="/customer-login">Already have an Account? Login Here</a>
          </div>
        </div>
      </div>
    </SharedLayout>
  );
}
