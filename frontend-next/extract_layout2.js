const fs = require('fs');
const content = fs.readFileSync('/Users/kunal/Downloads/wetransfer_pawarhan_ecom-2-sql-gz_2026-09-23_0922/pawar/frontend-next/src/app/HomePageClient.tsx', 'utf8');

const collectionMenuMatch = content.match(/const COLLECTION_MENU = \[[\s\S]*?\];/);
const animatedSearchMatch = content.match(/function AnimatedSearchInput\(\{[\s\S]*?return \([\s\S]*?\);\n\}/);

const headerStart = content.indexOf('{/* ══════════ TOP BANNER ══════════ */}');
const headerEnd = content.indexOf('<main className="main-content">');
const headerHtml = content.slice(headerStart, headerEnd);

const footerStart = content.indexOf('{/* ══════════ FOOTER ══════════ */}');
const footerEnd = content.indexOf('</div>\n  );\n}');
const footerHtml = content.slice(footerStart, footerEnd);

let layoutComponent = `
"use client";
import React, { useState, useEffect, useCallback } from "react";
import { Search, ShoppingBag, Heart, User, Menu, X, ChevronDown, ChevronRight, Leaf, Star, CheckCircle, MapPin, Phone, Mail } from "lucide-react";
import { FaFacebook, FaInstagram, FaYoutube, FaWhatsapp } from "react-icons/fa";

${collectionMenuMatch ? collectionMenuMatch[0] : ""}

${animatedSearchMatch ? animatedSearchMatch[0] : ""}

export default function SharedLayout({ children }: { children: React.ReactNode }) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [openMobileSubmenu, setOpenMobileSubmenu] = useState<string | null>(null);
  const [scrolled, setScrolled] = useState(false);
  const [showScrollTop, setShowScrollTop] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 50);
      setShowScrollTop(window.scrollY > 300);
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

  const scrollToTop = useCallback(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  }, []);

  return (
    <div style={{ background: "#fff", minHeight: "100vh" }}>
      ${headerHtml}
      
      <main className="main-content">
        {children}
      </main>

      ${footerHtml}
    </div>
  );
}
`;

fs.writeFileSync('/Users/kunal/Downloads/wetransfer_pawarhan_ecom-2-sql-gz_2026-09-23_0922/pawar/frontend-next/src/components/SharedLayout.tsx', layoutComponent);
console.log("Extracted SharedLayout.tsx successfully!");
