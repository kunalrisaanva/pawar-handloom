"use client";
import React, { useState, useEffect, useCallback, useRef } from "react";
import {
  Search,
  ShoppingBag,
  User,
  Menu,
  X,
  ChevronDown,
  ChevronRight,
  Star,
  CheckCircle,
  MapPin,
  Phone,
  Mail,
  ChevronUp,
  LogOut,
} from "lucide-react";
import { FaFacebook, FaInstagram, FaYoutube, FaWhatsapp } from "react-icons/fa";
import { getStoredUser, logoutUser, AuthUser } from "@/lib/auth";

const COLLECTION_MENU = [
  {
    name: "Maheshwari Sarees",
    href: "/shop/2/1",
    children: [
      { name: "Pure Silk Cotton Sarees", href: "/shop/2/1/1" },
      { name: "Pure Silk Sarees", href: "/shop/2/1/2" },
      { name: "Pure Tissue Saree", href: "/shop/2/1/3" },
      { name: "Pure Organza Saree", href: "/shop/2/1/7" },
      { name: "Pure Mulberry", href: "/shop/2/1/8" },
    ],
  },
  {
    name: "Chanderi Sarees",
    href: "/shop/2/2",
    children: [
      { name: "Pure Silk Cotton Saree", href: "/shop/2/2/4" },
      { name: "Pure Katan Silk Saree", href: "/shop/2/2/5" },
      { name: "Pure Pattu Silk Saree", href: "/shop/2/2/6" },
    ],
  },
  { name: "Handblock Printed Sarees", href: "/shop/2/3" },
  { name: "Pure Cotton Sarees", href: "/shop/2/5" },
];

function AnimatedSearchInput({ className }: { className?: string }) {
  const [text, setText] = useState("");
  const [isDeleting, setIsDeleting] = useState(false);
  const [loopNum, setLoopNum] = useState(0);
  const [inputValue, setInputValue] = useState("");
  const [searchResults, setSearchResults] = useState("");
  const [showDropdown, setShowDropdown] = useState(false);
  const searchRef = useRef<HTMLDivElement>(null);

  // Close dropdown on outside click
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (
        searchRef.current &&
        !searchRef.current.contains(event.target as Node)
      ) {
        setShowDropdown(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  // Live Search effect
  useEffect(() => {
    const delayDebounceFn = setTimeout(async () => {
      if (inputValue.length >= 2) {
        try {
          const formData = new FormData();
          formData.append("keyword", inputValue);
          const res = await fetch("http://localhost:8080/search", {
            method: "POST",
            body: formData,
          });
          const data = await res.json();
          if (data.status === "success" || data.status === "empty") {
            setSearchResults(
              data.html || "<div style='padding:10px;'>No products found</div>",
            );
            setShowDropdown(true);
          }
        } catch (e) {
          console.error(e);
        }
      } else {
        setSearchResults("");
        setShowDropdown(false);
      }
    }, 400);
    return () => clearTimeout(delayDebounceFn);
  }, [inputValue]);

  const words = ["Lehenga", "Saree", "Suit Sets", "Dress Material"];
  const typingSpeed = 100;
  const deletingSpeed = 50;
  const pauseTime = 1500;

  useEffect(() => {
    let timer: number;
    const current = loopNum % words.length;
    const fullText = words[current];

    if (isDeleting) {
      timer = window.setTimeout(() => {
        setText(fullText.substring(0, text.length - 1));
      }, deletingSpeed);
    } else {
      timer = window.setTimeout(() => {
        setText(fullText.substring(0, text.length + 1));
      }, typingSpeed);
    }

    if (!isDeleting && text === fullText) {
      timer = window.setTimeout(() => setIsDeleting(true), pauseTime);
    } else if (isDeleting && text === "") {
      setIsDeleting(false);
      setLoopNum((prev) => prev + 1);
    }

    return () => window.clearTimeout(timer);
  }, [text, isDeleting, loopNum]);

  return (
    <div
      ref={searchRef}
      style={{
        position: "relative",
        flex: 1,
        display: "flex",
        alignItems: "center",
      }}
    >
      {!inputValue && (
        <div
          style={{
            position: "absolute",
            left: 0,
            pointerEvents: "none",
            color: "#999",
            fontSize: "13px",
          }}
        >
          <span style={{ color: "#ac4024" }}>Search</span> {text}...
        </div>
      )}
      <input
        type="text"
        value={inputValue}
        onChange={(e) => {
          setInputValue(e.target.value);
          setShowDropdown(true);
        }}
        onFocus={() => {
          if (inputValue.length >= 2) setShowDropdown(true);
        }}
        className={className}
      />
      {showDropdown && searchResults && (
        <div
          className="search-results-dropdown"
          style={{
            position: "absolute",
            top: "100%",
            left: 0,
            width: "100%",
            minWidth: "300px",
            background: "#fff",
            border: "1px solid #ddd",
            borderRadius: "4px",
            boxShadow: "0 4px 12px rgba(0,0,0,0.1)",
            zIndex: 100,
            marginTop: "8px",
            maxHeight: "400px",
            overflowY: "auto",
          }}
          dangerouslySetInnerHTML={{ __html: searchResults }}
        />
      )}
    </div>
  );
}

export default function SharedLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [openMobileSubmenu, setOpenMobileSubmenu] = useState<string | null>(
    null,
  );
  const [scrolled, setScrolled] = useState(false);
  const [showScrollTop, setShowScrollTop] = useState(false);
  const [cartCount, setCartCount] = useState(0);
  const [currentUser, setCurrentUser] = useState<AuthUser | null>(null);

  // Sync auth state
  useEffect(() => {
    setCurrentUser(getStoredUser());
    const handleAuthChange = () => {
      setCurrentUser(getStoredUser());
    };
    window.addEventListener("auth_change", handleAuthChange);
    window.addEventListener("storage", handleAuthChange);
    return () => {
      window.removeEventListener("auth_change", handleAuthChange);
      window.removeEventListener("storage", handleAuthChange);
    };
  }, []);

  // Fetch cart data globally
  useEffect(() => {
    fetch("http://localhost:8080/cart/api", { credentials: "include" })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success" && data.items) {
          const count = data.items.reduce(
            (sum: number, item: any) => sum + parseInt(item.qty || 0, 10),
            0,
          );
          setCartCount(count);
        }
      })
      .catch(console.error);
  }, []);

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
      {/* ══════════ TOP BANNER ══════════ */}
      <div className="top-banner">
        <div className="marquee-content">
          <span>Free Shipping above ₹4000 (prepaid order)</span>
          <span>Buy 2 & Get Extra 7% Off — Use Code B2G7</span>
          <span>Buy 3 & Get Extra 10% Off — Use Code B3G10</span>
          <span>Free Shipping above ₹4000 (prepaid order)</span>
        </div>
      </div>

      {/* ══════════ MAIN HEADER ══════════ */}
      <header className="main-header">
        <div className="header-top-row">
          {/* Left: Review Pill (desktop) / Menu button (mobile) */}
          <div className="header-review-pill-container">
            <button
              className="mobile-menu-toggle"
              aria-label="Open menu"
              onClick={() => setMobileMenuOpen(true)}
            >
              <Menu size={24} />
            </button>
            <div className="header-review-pill">
              <img
                src="https://ui-avatars.com/api/?name=Swetha+Reddy&background=random"
                alt="Swetha Reddy"
              />
              <span>Swetha Reddy</span>
              <span style={{ color: "#ddd" }}>|</span>
              <div className="stars">
                <Star size={12} fill="currentColor" /> 5
              </div>
              <span className="review-text">
                The fabric feels soft and premium.
              </span>
            </div>
          </div>

          {/* Center: Logo */}
          <div className="header-logo">
            <a href="/">
              <img
                src="https://pawarhandloom.com/public/frontend/img/logo.png"
                alt="Pawar Handloom"
              />
            </a>
          </div>

          {/* Right: Actions */}
          <div className="header-actions-container">
            <div className="header-actions">
              <div className="header-search">
                <Search size={16} />
                <AnimatedSearchInput />
              </div>
              <a href="/cart" style={{ position: "relative" }}>
                <ShoppingBag size={20} />
                <span className="cart-badge">{cartCount}</span>
              </a>
              <div className="user-dropdown">
                <a href={currentUser ? "/profile" : "/customer-login"} title={currentUser ? currentUser.name : "My Profile"}>
                  <User size={20} />
                </a>
                <ul className="user-dropdown-menu">
                  {currentUser ? (
                    <>
                      <li className="user-dropdown-header">
                        <div className="user-dropdown-header-name">Hi, {currentUser.name}</div>
                        {currentUser.email && <div className="user-dropdown-header-email">{currentUser.email}</div>}
                      </li>
                      <li>
                        <a href="/profile">My Profile</a>
                      </li>
                      <li>
                        <a href="/cart">My Orders</a>
                      </li>
                      <li>
                        <button
                          type="button"
                          className="logout-action"
                          onClick={async () => {
                            await logoutUser();
                          }}
                        >
                          <LogOut size={14} />
                          <span>Logout</span>
                        </button>
                      </li>
                    </>
                  ) : (
                    <>
                      <li>
                        <a href="/customer-login">Customer Login</a>
                      </li>
                      <li>
                        <a href="/customer-register">Customer Register</a>
                      </li>
                      <li>
                        <a href="/login">Reseller Login</a>
                      </li>
                      <li>
                        <a href="/register">Resellers Register</a>
                      </li>
                    </>
                  )}
                </ul>
              </div>
            </div>
          </div>
        </div>

        {/* Navigation Row */}
        <div className="header-nav-row">
          <nav>
            <ul className="main-nav">
              <li>
                <a href="/new-arrivals">New Arrival</a>
              </li>
              <li>
                <a href="/shop/7">Best Seller</a>
              </li>
              <li>
                <a href="/shop/2">Lehenga</a>
              </li>
              <li>
                <a href="/shop/3">Suit Sets</a>
              </li>
              <li>
                <a href="/shop/3">Dresses</a>
              </li>
              <li>
                <a href="/shop/2">Shop All</a>
              </li>
              <li>
                <a href="#">
                  Shop by Collection{" "}
                  <ChevronDown size={14} style={{ marginTop: 2 }} />
                </a>
                <ul className="dropdown">
                  {COLLECTION_MENU.map((item) => (
                    <li key={item.name}>
                      <a href={item.href}>
                        {item.name}
                        {item.children && (
                          <ChevronRight
                            size={12}
                            style={{ float: "right", marginTop: 3 }}
                          />
                        )}
                      </a>
                      {item.children && (
                        <ul className="sub-dropdown">
                          {item.children.map((sub) => (
                            <li key={sub.name}>
                              <a href={sub.href}>{sub.name}</a>
                            </li>
                          ))}
                        </ul>
                      )}
                    </li>
                  ))}
                </ul>
              </li>
              <li>
                <a href="/about">About</a>
              </li>
            </ul>
          </nav>
        </div>
      </header>

      {/* ══════════ MOBILE NAV ══════════ */}
      {mobileMenuOpen && (
        <>
          <div
            className="mobile-nav-overlay"
            onClick={() => setMobileMenuOpen(false)}
          />
          <div className="mobile-nav">
            <div className="mobile-nav-head">
              <img
                src="https://pawarhandloom.com/public/frontend/img/logo.png"
                alt="Pawar Handloom"
              />
              <button
                aria-label="Close menu"
                onClick={() => setMobileMenuOpen(false)}
                style={{
                  background: "none",
                  border: "none",
                  cursor: "pointer",
                }}
              >
                <X size={24} />
              </button>
            </div>
            <div className="mobile-nav-search">
              <Search size={16} />
              <AnimatedSearchInput />
            </div>
            <ul>
              <li>
                <a href="/new-arrivals">New Arrival</a>
              </li>
              <li>
                <a href="/shop/7">Best Seller</a>
              </li>
              <li>
                <a href="/shop/2">
                  Lehenga <span className="mobile-nav-badge">NEW</span>
                </a>
              </li>
              <li>
                <a href="/shop/3">Suit Sets</a>
              </li>
              <li>
                <a href="/shop/3">Dresses</a>
              </li>
              <li>
                <a href="/shop/2">Shop All</a>
              </li>
              <li>
                <a
                  href="#"
                  onClick={(e) => {
                    e.preventDefault();
                    setOpenMobileSubmenu(
                      openMobileSubmenu === "collection" ? null : "collection",
                    );
                  }}
                  style={{
                    display: "flex",
                    justifyContent: "space-between",
                    alignItems: "center",
                  }}
                >
                  Collection
                  <ChevronDown
                    size={16}
                    style={{
                      transform:
                        openMobileSubmenu === "collection"
                          ? "rotate(180deg)"
                          : "none",
                      transition: "transform 0.3s",
                    }}
                  />
                </a>
                {openMobileSubmenu === "collection" && (
                  <ul style={{ paddingLeft: 15 }}>
                    {COLLECTION_MENU.map((item) => (
                      <li key={item.name}>
                        <a href={item.href}>{item.name}</a>
                      </li>
                    ))}
                  </ul>
                )}
              </li>
              <li>
                <a href="/about">About Us</a>
              </li>
              <li>
                <a href="/gallery">Gallery</a>
              </li>
              <li>
                <a href="/contact">Contact</a>
              </li>
              <li>
                <a href="/review">Review</a>
              </li>
            </ul>
            <div className="mobile-nav-account">
              {currentUser ? (
                <>
                  <div className="mobile-nav-user-header">
                    <div className="name">Hi, {currentUser.name}</div>
                    {currentUser.email && <div className="email">{currentUser.email}</div>}
                  </div>
                  <a href="/profile" onClick={() => setMobileMenuOpen(false)}>My Profile</a>
                  <a href="/cart" onClick={() => setMobileMenuOpen(false)}>My Orders</a>
                  <button
                    type="button"
                    className="mobile-logout-btn"
                    onClick={async () => {
                      setMobileMenuOpen(false);
                      await logoutUser();
                    }}
                  >
                    <LogOut size={15} />
                    <span>Logout</span>
                  </button>
                </>
              ) : (
                <>
                  <a href="/customer-login" onClick={() => setMobileMenuOpen(false)}>Customer Login</a>
                  <a href="/customer-register" onClick={() => setMobileMenuOpen(false)}>Customer Register</a>
                  <a href="/login" onClick={() => setMobileMenuOpen(false)}>Reseller Login</a>
                  <a href="/register" onClick={() => setMobileMenuOpen(false)}>Resellers Register</a>
                </>
              )}
            </div>
          </div>
        </>
      )}

      <main className="main-content">{children}</main>

      {/* ══════════ FOOTER ══════════ */}
      <footer className="footer-new">
        <div className="footer-top-grid">
          {/* Brand column */}
          <div className="footer-col footer-brand">
            <img
              src="https://pawarhandloom.com/public/frontend/img/logo.png"
              alt="Pawar Handloom"
              className="footer-logo"
            />
            <p className="footer-tagline">
              Handwoven sarees &amp; suits straight from the looms of Maheshwar,
              Madhya Pradesh.
            </p>

            <ul className="footer-contact-list">
              <li>
                <Phone size={15} />
                <span>
                  (+91) 9630504663 <em>WhatsApp</em>
                  <br />
                  (+91) 9039119245 <em>Call</em>
                </span>
              </li>
              <li>
                <Mail size={15} />
                <a href="mailto:support@pawarhandloom.com">
                  support@pawarhandloom.com
                </a>
              </li>
              <li>
                <MapPin size={15} />
                <span>Pawar Handloom, Maheshwar, Madhya Pradesh - 451224</span>
              </li>
            </ul>

            <div className="footer-social">
              <a
                href="https://www.facebook.com/Official.PawarHandloom/"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Facebook"
              >
                <FaFacebook size={16} />
              </a>
              <a
                href="https://www.instagram.com/official_pawarhandloom/?utm_source=ig_embed&ig_rid=ANSZzKd7RpOjbAQrbnZWD4-"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Instagram"
              >
                <FaInstagram size={16} />
              </a>
              <a
                href="https://www.youtube.com"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="YouTube"
              >
                <FaYoutube size={16} />
              </a>
            </div>

            <img
              src="https://images.dmca.com/Badges/dmca-badge-w100-5x1-07.png?ID=bullionknot"
              alt="DMCA Protected"
              className="footer-dmca-badge"
            />
          </div>

          {/* Column 1 */}
          <div className="footer-col">
            <h4>DESIGNER WEAR</h4>
            <ul>
              <li>
                <a href="/new-arrivals">New Arrival</a>
              </li>
              <li>
                <a href="#">Same Day Dispatch</a>
              </li>
              <li>
                <a href="/shop/2">Lehenga</a>
              </li>
              <li>
                <a href="/shop/3">Suit Sets</a>
              </li>
              <li>
                <a href="/shop/3">Dresses</a>
              </li>
              <li>
                <a href="#">Can Can Skirt</a>
              </li>
              <li>
                <a href="#">Lehenga Bundle</a>
              </li>
              <li>
                <a href="#">Banarasi Dresses</a>
              </li>
              <li>
                <a href="#">Lehengas Under 7999</a>
              </li>
              <li>
                <a href="#">Half Saree Under 6999</a>
              </li>
            </ul>
          </div>

          {/* Column 2 */}
          <div className="footer-col">
            <h4>MY ACCOUNT</h4>
            <ul>
              <li>
                <a href="#">My Account</a>
              </li>
              <li>
                <a href="/register">Register</a>
              </li>
              <li>
                <a href="/login">Login</a>
              </li>
              <li>
                <a href="#">View Order</a>
              </li>
            </ul>
          </div>

          {/* Column 3 */}
          <div className="footer-col">
            <h4>CUSTOMER SERVICE</h4>
            <ul>
              <li>
                <a href="#">Terms & Condition</a>
              </li>
              <li>
                <a href="#">Privacy Policy</a>
              </li>
              <li>
                <a href="#">Shipping Policy</a>
              </li>
              <li>
                <a href="#">Return & Exchange Policy</a>
              </li>
              <li>
                <a href="#">Sitemap</a>
              </li>
            </ul>
          </div>

          {/* Column 4 */}
          <div className="footer-col">
            <h4>INFORMATION</h4>
            <ul>
              <li>
                <a href="#">Blogs</a>
              </li>
              <li>
                <a href="/about">About Us</a>
              </li>
              <li>
                <a href="/contact">Contact Us</a>
              </li>
              <li>
                <a href="#">Wholesale Inquiry</a>
              </li>
              <li>
                <a href="#">Franchise Inquiry</a>
              </li>
            </ul>
          </div>
        </div>

        {/* Watermark Background */}
        <div className="footer-watermark">Pawar Handloom</div>

        {/* Copyright Bar */}
        <div className="footer-copyright">
          ALL RIGHTS RESERVED. © PAWAR HANDLOOM 2026 .
        </div>
      </footer>

      {/* ══════════ FLOATING ELEMENTS ══════════ */}
      <a
        href="/review"
        className="reviews-tab"
        style={{ textDecoration: "none" }}
        aria-label="Customer Reviews"
      >
        <span>★</span> REVIEWS
      </a>
      <a
        href="https://wa.me/919630504663"
        className="float-whatsapp"
        target="_blank"
        rel="noopener noreferrer"
      >
        <FaWhatsapp size={28} />
      </a>
      <a href="tel:+919630504663" className="float-call">
        <Phone size={16} /> Call Now
      </a>

      {/* Scroll to top */}
      {showScrollTop && (
        <button className="scroll-top" onClick={scrollToTop}>
          <ChevronUp size={20} />
        </button>
      )}
    </div>
  );
}
