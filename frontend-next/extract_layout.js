const fs = require('fs');
const content = fs.readFileSync('/Users/kunal/Downloads/wetransfer_pawarhan_ecom-2-sql-gz_2026-09-23_0922/pawar/frontend-next/src/app/HomePageClient.tsx', 'utf8');

const collectionMenuMatch = content.match(/const COLLECTION_MENU = \[[\s\S]*?\];\n/);
const animatedSearchMatch = content.match(/function AnimatedSearchInput\(\{[\s\S]*?return \([\s\S]*?\);\n\}/);

const headerMatch = content.match(/\{\/\* ══════════ TOP BANNER ══════════ \*\/\}([\s\S]*?)<main className="main-content">/);
const footerMatch = content.match(/\{\/\* ══════════ FOOTER ══════════ \*\/\}([\s\S]*?)<\/div>\n  \);\n\}/);

let layoutComponent = `
"use client";
import React, { useState, useEffect, useCallback } from "react";
import { Search, ShoppingBag, Heart, User, Menu, X, ChevronDown, ChevronRight, Leaf, Star, CheckCircle, MapPin, Phone, Mail, Facebook, Instagram, Youtube } from "lucide-react";
import { FaFacebook, FaInstagram, FaYoutube, FaWhatsapp } from "react-icons/fa";

${collectionMenuMatch ? collectionMenuMatch[0] : ""}

${animatedSearchMatch ? animatedSearchMatch[0] : ""}

export default function SharedLayout({ children }: { children: React.ReactNode }) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 50);
    };
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  useEffect(() => {
    document.body.style.overflow = mobileMenuOpen ? "hidden" : "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [mobileMenuOpen]);

  return (
    <div style={{ background: "#fff", minHeight: "100vh" }}>
      {/* ══════════ TOP BANNER ══════════ */}
      ${headerMatch ? headerMatch[1] : ""}
      
      <main className="main-content">
        {children}
      </main>

      {/* ══════════ FOOTER ══════════ */}
      ${footerMatch ? footerMatch[1] : ""}
    </div>
  );
}
`;

fs.writeFileSync('/Users/kunal/Downloads/wetransfer_pawarhan_ecom-2-sql-gz_2026-09-23_0922/pawar/frontend-next/src/components/SharedLayout.tsx', layoutComponent);
console.log("Extracted SharedLayout.tsx successfully!");
