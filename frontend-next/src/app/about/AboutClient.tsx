"use client";
import React from "react";
import SharedLayout from "@/components/SharedLayout";
import Link from "next/link";

export default function AboutClient() {
  return (
    <SharedLayout>
      <div 
        className="about-hero" 
        style={{
          backgroundImage: "url('https://pawarhandloom.com/public/frontend/img/hero/about.jpg')",
          backgroundSize: "cover",
          backgroundPosition: "center",
          height: "300px",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          position: "relative"
        }}
      >
        {/* Dark overlay to make text more readable */}
        <div style={{
          position: "absolute",
          top: 0, left: 0, right: 0, bottom: 0,
          backgroundColor: "rgba(0,0,0,0.4)"
        }}></div>
        
        <h1 style={{ 
          position: "relative",
          color: "#fff", 
          fontSize: "3rem", 
          fontFamily: "var(--font-serif)",
          letterSpacing: "1px",
          textShadow: "1px 1px 3px rgba(0,0,0,0.5)"
        }}>
          About Us
        </h1>
      </div>

      <div className="about-content" style={{ padding: "100px 20px", maxWidth: "1300px", margin: "0 auto" }}>
        <div style={{ 
          display: "grid", 
          gridTemplateColumns: "repeat(auto-fit, minmax(400px, 1fr))", 
          gap: "80px", 
          alignItems: "center" 
        }}>
          {/* Image Column - giving it a slightly larger visual presence via grid if space allows, but auto-fit works best */}
          <div style={{ width: "100%" }}>
            <img 
              src="https://pawarhandloom.com/public/frontend/img/collection/collection-1.png" 
              alt="Pawar Handloom Store" 
              style={{ width: "100%", height: "auto", borderRadius: "16px", boxShadow: "0 20px 40px rgba(0,0,0,0.1)" }} 
            />
          </div>
          {/* Text Column */}
          <div style={{ textAlign: "justify" }}>
            <h2 style={{ fontFamily: "var(--font-sans)", fontSize: "2rem", color: "#222", marginBottom: "20px", fontWeight: "700", letterSpacing: "-0.5px" }}>
              About Pawar Handloom
            </h2>
            <p style={{ fontSize: "1rem", lineHeight: "1.8", color: "#555", marginBottom: "16px", fontWeight: "400" }}>
              At present, we preserve the highest level of skill in traditional & contemporary woven textiles from Madhya Pradesh. As a tribute to the traditions of Indian classicism and in commemoration to push make in India, Pawar Handloom offers the most reputable & trusted store that exhibits the highest level of technical and aesthetic quality and pays homage to the pinnacles of the past.
            </p>
            <p style={{ fontSize: "1rem", lineHeight: "1.8", color: "#555", fontWeight: "400" }}>
              It is an honour for Pawar Handloom by Mr. Piyush K.N.K. Pawar to exhibit style of weaving techniques known as cloth of gold threads served as the ultimate inspiration for the woven saris which are classified on the basis of their borders or the patterns in them like Maheshwar bugdi kinar, zari patti, rui phool kinar, phool kinar, chatai kinar, V kinar, kahar kinar, bajuband kinar (narmada wave pattern in between silver and golden zari) and the like on our website and also revived the art of Handloom Weaving by calling in expert karigars.
            </p>
          </div>
        </div>
      </div>
    </SharedLayout>
  );
}
