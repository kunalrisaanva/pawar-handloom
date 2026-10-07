"use client";
import { useState, useEffect, useCallback, useRef, type ReactNode } from "react";
import { createPortal, flushSync } from "react-dom";
import {
  Phone,
  Mail,
  Search,
  User,
  ShoppingBag,
  ShoppingCart,
  Truck,
  Menu,
  MessageCircle,
  X,
  ChevronUp,
  MapPin,
  Heart,
  Scissors,
  Leaf,
  Star,
  ChevronRight,
  ChevronDown,
  Ticket,
  ChevronLeft,
  ArrowUpRight,
  CheckCircle,
  Play,
} from "lucide-react";
import { FaFacebook, FaInstagram, FaYoutube, FaWhatsapp } from "react-icons/fa";



/* ── Static Data ────────────────────────────────────────── */

const HERO_IMAGES = [
  {
    desktop: "/hero-desktop-1.png",
    mobile: "/pawar-handloom-3.png",
  },
  {
    desktop: "/hero-desktop-2.png",
    mobile: "/pawar-handloom-2.png",
  },
  {
    desktop: "/hero-desktop-3.png",
    mobile: "/whatsapp-image.jpeg",
  },
];

const SUBCATEGORIES = [
  { name: "Pure Silk Cotton Sarees", img: "/saree-icon.avif" },
  { name: "Pure Silk Sarees", img: "/saree-icon.avif" },
  { name: "Pure Tissue Saree", img: "/saree-icon.avif" },
  { name: "Pure Organza Saree", img: "/saree-icon.avif" },
  { name: "Pure Mulberry", img: "/saree-icon.avif" },
];

const NEW_ARRIVALS = [
  {
    name: "Pure Maheshwari Silver zari...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg",
    originalPrice: "4,500.00",
    salePrice: "4,050.00",
    discount: "10% OFF",
    badge: "NEW",
    readyToShip: true,
  },
  {
    name: "Pure Maheshwari golden zari...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg",
    originalPrice: "3,000.00",
    salePrice: "2,700.00",
    discount: "10% OFF",
    badge: "NEW",
    readyToShip: true,
  },
  {
    name: "Pure Maheshwari silver zari...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg",
    originalPrice: "2,750.00",
    salePrice: "2,475.00",
    discount: "10% OFF",
    badge: "NEW",
    readyToShip: true,
  },
  {
    name: "Pure Chanderi silk cotton...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg",
    originalPrice: "2,500.00",
    salePrice: "2,250.00",
    discount: "10% OFF",
    badge: "NEW",
    readyToShip: true,
  },
];

const SAREE_CATEGORIES = [
  { name: "Maheshwari Sarees", img: "/shop-category-1.png" },
  { name: "Chanderi Sarees", img: "/shop-category-2.png" },
  { name: "Handblock Printed Sarees", img: "/shop-category-3.png" },
  { name: "Pure Cotton Sarees", img: "/shop-category-4.png" },
];

const DRESS_MATERIALS = [
  {
    name: "Maheshwari Bagh Suits",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756383012_433d62525d79e078b558.jpeg",
    originalPrice: "2,500.00",
    salePrice: "2,250.00",
    discount: "10% OFF",
  },
  {
    name: "Dress Material",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756383095_26fdba15a2226f5bb2ad.jpeg",
    originalPrice: "2,500.00",
    salePrice: "2,250.00",
    discount: "10% OFF",
  },
  {
    name: "Dress Material",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756383177_1e6bdc13ee56da5dfa1e.jpeg",
    originalPrice: "2,500.00",
    salePrice: "2,250.00",
    discount: "10% OFF",
  },
  {
    name: "Dress Material",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756383264_e91a36f61bfd24b09aaf.jpeg",
    originalPrice: "2,500.00",
    salePrice: "2,250.00",
    discount: "10% OFF",
  },
];

const BEST_SELLERS = [
  {
    name: "Pure Maheshwari Silver zari...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg",
    originalPrice: "4,500.00",
    salePrice: "4,050.00",
    discount: "10% OFF",
    badge: "BESTSELLER",
  },
  {
    name: "Pure Maheshwari golden zari...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg",
    originalPrice: "3,000.00",
    salePrice: "2,700.00",
    discount: "10% OFF",
    badge: "BESTSELLER",
  },
  {
    name: "Pure Maheshwari silver zari...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg",
    originalPrice: "2,750.00",
    salePrice: "2,475.00",
    discount: "10% OFF",
    badge: "BESTSELLER",
  },
  {
    name: "Pure Chanderi silk cotton...",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg",
    originalPrice: "2,500.00",
    salePrice: "2,250.00",
    discount: "10% OFF",
    badge: "BESTSELLER",
  },
];

const SEE_IT_LOVE_IT = [
  {
    name: "Maheshwari Heavy Pallu Saree",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg",
    originalPrice: "10,000.00",
    salePrice: "9,000.00",
    discount: "10% OFF",
  },
  {
    name: "Maheshwari saree",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg",
    originalPrice: "7,500.00",
    salePrice: "6,750.00",
    discount: "10% OFF",
  },
  {
    name: "Maheshwari Pure Mullbery Silk Saree",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg",
    originalPrice: "22,000.00",
    salePrice: "19,800.00",
    discount: "10% OFF",
  },
  {
    name: "Silver Boarder Saree",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg",
    originalPrice: "6,300.00",
    salePrice: "5,670.00",
    discount: "10% OFF",
  },
  {
    name: "Maheshwari Saree",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756383012_433d62525d79e078b558.jpeg",
    originalPrice: "5,700.00",
    salePrice: "5,130.00",
    discount: "10% OFF",
  },
  {
    name: "Maheshwari saree",
    img: "https://pawarhandloom.com/public/uploads/products/cover/1756383095_26fdba15a2226f5bb2ad.jpeg",
    originalPrice: "5,800.00",
    salePrice: "5,220.00",
    discount: "10% OFF",
  },
];

const COLLECTION_MENU = [
  {
    name: "Sarees",
    href: "/shop/2",
    children: [
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
    ],
  },
  {
    name: "Dress material",
    href: "/shop/3",
    children: [
      {
        name: "Maheshwari Dress Material",
        href: "/shop/3/6",
        children: [
          { name: "Top and Dupatta set", href: "/shop/3/6/9" },
          { name: "Full Dress Material", href: "/shop/3/6/10" },
        ],
      },
      {
        name: "Chanderi Dress Material",
        href: "/shop/3/7",
        children: [
          { name: "Top and Dupatta set", href: "/shop/3/7/11" },
          { name: "Full Dress Material", href: "/shop/3/7/12" },
        ],
      },
      { name: "HandBlock Dress Material", href: "/shop/3/8" },
      { name: "Pure Cotton Dress Material", href: "/shop/3/9" },
    ],
  },
  { name: "Stoles/Dupatta", href: "/shop/4" },
  { name: "New Arrivals", href: "/shop/6" },
  { name: "Best Sellers", href: "/shop/7" },
  { name: "Celebs Look", href: "/shop/8" },
];

const OCCASIONS = [
  { name: "Wedding", styles: "97 Styles", img: "https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg" },
  { name: "Reception", styles: "81 Styles", img: "https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg" },
  { name: "Haldi", styles: "17 Styles", img: "https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg" },
  { name: "Mehendi", styles: "24 Styles", img: "https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg" },
];

const CUSTOMER_REVIEWS: Array<{ name: string; text: string; product: string; video?: string; img?: string }> = [
  {
    name: "Snigdha Agrawal",
    text: '"The colours, fabric quality, and detailing were beautiful, and it looked stunning in photos. Comfortable, elegant, and gave a complete traditional bridal vibe. Received so many compliments—highly recommended!"',
    product: "Indira Vastra | Soft Silk Lehenga Set in Lime Green for Stylish Occasions",
    video: "https://res.cloudinary.com/dk5zp1gfw/video/upload/v1789124497/SaveClip.App_AQP0kzSHqkm4JTqDkk4MfAq8So4b4Lnou-7_fDEIfrfhAAA9DvOXz1W267abrLpDJaBBiaN7zaAaCRo70FvMMv1rGOAvMSwbo7DPpYM.mp4",
  },
  {
    name: "Ram Sujitha",
    text: '"The fabric feels so premium, and everyone at the family event praised it. Best purchase of the year, and I recommend this to every woman out there to look like a queen"',
    product: "Patti Rani Pink Madhubala Lehenga Set",
    video: "https://res.cloudinary.com/dk5zp1gfw/video/upload/v1789124497/SaveClip.App_AQP0kzSHqkm4JTqDkk4MfAq8So4b4Lnou-7_fDEIfrfhAAA9DvOXz1W267abrLpDJaBBiaN7zaAaCRo70FvMMv1rGOAvMSwbo7DPpYM.mp4",
  },
  {
    name: "Anugraha Sudheer",
    text: '"The lehenga was very beautiful. For the blouse, I did a little alteration because I had ordered a small size instead of XS. The lehenga was very comfortable as well as very pretty"',
    product: "Maharani Red Lehenga Set",
    video: "https://res.cloudinary.com/dk5zp1gfw/video/upload/v1789124497/SaveClip.App_AQP0kzSHqkm4JTqDkk4MfAq8So4b4Lnou-7_fDEIfrfhAAA9DvOXz1W267abrLpDJaBBiaN7zaAaCRo70FvMMv1rGOAvMSwbo7DPpYM.mp4",
  },
  {
    name: "Megha Premkumar",
    text: '"I just love this brand bullion knot, you guys are my saviours. Whenever I wear their dresses or half sarees, I get lots of compliments. One of the best ethnic wear brands."',
    product: "Nishkala Gadval Lime Lehenga Set",
    video: "https://res.cloudinary.com/dk5zp1gfw/video/upload/v1789124497/SaveClip.App_AQP0kzSHqkm4JTqDkk4MfAq8So4b4Lnou-7_fDEIfrfhAAA9DvOXz1W267abrLpDJaBBiaN7zaAaCRo70FvMMv1rGOAvMSwbo7DPpYM.mp4",
  },
];

const REELS = [
  {
    video: "https://res.cloudinary.com/e6ukjf8q/video/upload/v1789127702/final_correction_xsqzxo.mp4",
    title: "Maheshwari Silk Saree",
    subtitle: "Traditional Weave Collection",
  },
  {
    video: "https://res.cloudinary.com/e6ukjf8q/video/upload/v1789128094/03_gjkzu7.mp4",
    title: "Chanderi Cotton Saree",
    subtitle: "Handcrafted Elegance",
  },
  {
    video: "https://res.cloudinary.com/e6ukjf8q/video/upload/v1789128322/04_nbw5a8.mp4",
    title: "Handblock Printed Saree",
    subtitle: "Artisan Made Heritage",
  },
  {
    video: "https://res.cloudinary.com/e6ukjf8q/video/upload/v1789129039/05_1_zgkk2i.mp4",
    title: "Designer Collection",
    subtitle: "Exclusive Royal Weaves",
  },
];

/* ── SVG Icons ── */
function RoseIcon() {
  return (
    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="20" cy="20" r="14" stroke="#ac4024" strokeWidth="1" fill="#fff" />
      <path d="M12 20 Q 20 5 28 20 Q 20 35 12 20 Z" stroke="#ac4024" strokeWidth="1" fill="none" />
      <path d="M20 12 Q 35 20 20 28 Q 5 20 20 12 Z" stroke="#ac4024" strokeWidth="1" fill="none" />
      <circle cx="20" cy="20" r="4" stroke="#ac4024" strokeWidth="1" fill="none" />
    </svg>
  );
}

function SareeWomanIcon() {
  return (
    <svg width="60" height="80" viewBox="0 0 60 80" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M30 20C26 20 23 17 23 13C23 9 26 6 30 6C34 6 37 9 37 13C37 17 34 20 30 20Z" fill="#111827"/>
      <path d="M38.5 24C34.8 21.5 28.5 22 25.5 26.5C23 30.5 23.5 45.5 23.5 45.5C23.5 45.5 19 36 17 34C15.5 32.5 12 36.5 14 39C16.5 42 22 51.5 22 51.5V74H43C43 74 38.5 56 39.5 42C40 33 42 26.5 38.5 24Z" fill="#111827"/>
      <path d="M30 74L35 48C37 38 35 29 27 24C27 24 35 34 33 48L25 74H30Z" fill="#e2e8f0" opacity="0.3"/>
      <path d="M37 74L40 50C41 40 40 30 31 25C31 25 39 35 38 50L32 74H37Z" fill="#e2e8f0" opacity="0.2"/>
      <circle cx="10" cy="28" r="3" fill="#111827"/>
      <path d="M10 28L15 35" stroke="#111827" strokeWidth="2"/>
    </svg>
  );
}

/* ── Decorative Flower SVG (matches the golden ornament on the live site) ── */
/* ── Section title ornaments — one gold motif per section, slowly spinning ── */
const GOLD = "#c4993f";

// Repeat a shape `count` times evenly around the centre (16,16)
const around = (count: number, render: (angle: number, i: number) => ReactNode) =>
  Array.from({ length: count }, (_, i) => render((360 / count) * i, i));

// Points of a star centred on (16,16)
const starPoints = (tips: number, outer: number, inner: number) =>
  Array.from({ length: tips * 2 }, (_, i) => {
    const r = i % 2 ? inner : outer;
    const t = (Math.PI * i) / tips - Math.PI / 2;
    return `${(16 + r * Math.cos(t)).toFixed(2)},${(16 + r * Math.sin(t)).toFixed(2)}`;
  });

const HEART = "M16 14C16 14 11 10.8 11 7.6C11 5.9 12.3 4.6 13.9 4.6C14.8 4.6 15.6 5.1 16 5.9C16.4 5.1 17.2 4.6 18.1 4.6C19.7 4.6 21 5.9 21 7.6C21 10.8 16 14 16 14Z";

const ORNAMENTS = {
  // New Arrivals — fresh sparkle
  sparkle: (
    <>
      <path d="M16 2C17 11 21 15 30 16C21 17 17 21 16 30C15 21 11 17 2 16C11 15 15 11 16 2Z" />
      {[[7, 7], [25, 7], [7, 25], [25, 25]].map(([x, y]) => (
        <circle key={`${x}-${y}`} cx={x} cy={y} r={1.8} />
      ))}
    </>
  ),
  // Shop By Category — lotus
  lotus: (
    <>
      {around(8, (a, i) => (
        <ellipse key={a} cx="16" cy={i % 2 ? 8.5 : 7.5} rx="2.8" ry={i % 2 ? 4.5 : 5.5} opacity={i % 2 ? 0.7 : 1} transform={`rotate(${a} 16 16)`} />
      ))}
      <circle cx="16" cy="16" r="3.2" />
    </>
  ),
  // Dress Materials — charkha (spinning wheel)
  charkha: (
    <>
      <g fill="none" stroke={GOLD} strokeLinecap="round">
        <circle cx="16" cy="16" r="12.5" strokeWidth="2.2" />
        {around(8, (a) => (
          <line key={a} x1="16" y1="13" x2="16" y2="4" strokeWidth="1.6" transform={`rotate(${a} 16 16)`} />
        ))}
      </g>
      <circle cx="16" cy="16" r="3" />
    </>
  ),
  // Best Sellers — award rosette
  rosette: (
    <>
      <path
        fillRule="evenodd"
        d={`M${starPoints(16, 15, 12).join(" L")}Z M24 16A8 8 0 1 0 8 16A8 8 0 1 0 24 16Z`}
      />
      <polygon points={starPoints(5, 5.5, 2.3).join(" ")} />
    </>
  ),
  // See It. Love It. Own It. — flower of hearts
  hearts: (
    <>
      {around(4, (a) => <path key={a} d={HEART} transform={`rotate(${a} 16 16)`} />)}
      {around(4, (a) => <circle key={a} cx="16" cy="4" r="1.5" transform={`rotate(${a + 45} 16 16)`} />)}
      <circle cx="16" cy="16" r="1.8" />
    </>
  ),
  // Celebs Look — spotlight sun
  sun: (
    <>
      <circle cx="16" cy="16" r="5.5" />
      <g stroke={GOLD} strokeLinecap="round">
        {around(12, (a, i) => (
          <line key={a} x1="16" y1="8" x2="16" y2={i % 2 ? 4.5 : 2} strokeWidth={i % 2 ? 1.6 : 2.2} transform={`rotate(${a} 16 16)`} />
        ))}
      </g>
    </>
  ),
};

function SectionOrnament({ kind, reverse = false }: { kind: keyof typeof ORNAMENTS; reverse?: boolean }) {
  return (
    <img
      src="/section-title-ornament.png"
      className={`section-ornament${reverse ? " is-reverse" : ""}`}
      alt="Ornament"
    />
  );
}

/* ── Animated Search Input ── */
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
      if (searchRef.current && !searchRef.current.contains(event.target as Node)) {
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
            setSearchResults(data.html || "<div style='padding:10px;'>No products found</div>");
            setShowDropdown(true);
          }
        } catch(e) {
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
    <div ref={searchRef} style={{ position: "relative", flex: 1, display: "flex", alignItems: "center" }}>
      {!inputValue && (
        <div style={{ position: "absolute", left: 0, pointerEvents: "none", color: "#999", fontSize: "13px" }}>
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
            overflowY: "auto"
          }}
          dangerouslySetInnerHTML={{ __html: searchResults }}
        />
      )}
    </div>
  );
}

/* ── Product Card Component ── */
// Actual product images are used below

// "4,050.00" → "₹4,050"
const formatPrice = (price: string | number) => `₹${String(price).replace(/\.00$/, "")}`;

function ProductCard({
  name,
  img,
  originalPrice,
  salePrice,
  discount,
  badge,
  readyToShip,
  rating,
  reviewCount,
  sizes,
  id,
}: {
  name: string;
  img: string;
  originalPrice: string;
  salePrice: string;
  discount: string;
  badge?: string; // e.g. "NEW", "BESTSELLER" — corner tag on the photo
  readyToShip?: boolean;
  rating?: number; // real review data only — the row is hidden without it
  reviewCount?: number;
  sizes?: string[]; // lehengas / suit sets / dresses; sarees leave this out
  id?: string | number;
}) {
  const [liked, setLiked] = useState(false);

  return (
    <div className="product-card">
      <div className="product-card-media">
        <img src={img} alt={name} className="product-card-img" loading="lazy" />
        {badge && <span className="product-card-badge">{badge}</span>}
        <button
          type="button"
          className={`product-card-wishlist${liked ? " is-active" : ""}`}
          aria-label={liked ? "Remove from wishlist" : "Add to wishlist"}
          aria-pressed={liked}
          onClick={() => setLiked(!liked)}
        >
          <Heart size={26} strokeWidth={1.75} fill={liked ? "currentColor" : "none"} />
        </button>
      </div>

      <div className="product-card-body">
        {(rating !== undefined || readyToShip) && (
          <div className="product-card-meta">
            {rating !== undefined && (
              <span className="product-card-rating">
                <Star size={16} fill="currentColor" strokeWidth={0} />
                <strong>{rating.toFixed(1)}</strong>
                {reviewCount !== undefined && <span>({reviewCount})</span>}
              </span>
            )}
            {readyToShip && (
              <span className="product-card-ship">
                <Truck size={18} strokeWidth={1.75} /> Ready to Ship
              </span>
            )}
          </div>
        )}
        <h4 className="product-card-name" title={name}>{name}</h4>
        <div className="product-card-footer">
          <div className="product-card-pricing">
            <p className="product-card-price">
              {formatPrice(salePrice)}
              <span className="original">{formatPrice(originalPrice)}</span>
              <span className="off">{discount}</span>
            </p>
            {sizes && sizes.length > 0 && (
              <ul className="product-card-sizes" aria-label="Available sizes">
                {sizes.map((size) => (
                  <li key={size}>{size}</li>
                ))}
              </ul>
            )}
          </div>
          <button 
            type="button" 
            className="product-card-cart" 
            aria-label={`Add ${name} to cart`}
            onClick={async () => {
              if (!id) {
                alert("Cannot add to cart without ID");
                return;
              }
              try {
                const formData = new URLSearchParams();
                formData.append('id', id.toString());
                formData.append('product_name', name);
                formData.append('offer_price', salePrice);
                formData.append('qty', '1');
                formData.append('image', img);
                formData.append('color', '');

                const response = await fetch('http://localhost:8080/cart/add', {
                  method: 'POST',
                  credentials: 'include',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                  },
                  body: formData.toString()
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                  alert(result.message || 'Product added to cart!');
                  // Optionally trigger a cart refresh here
                } else {
                  alert('Failed to add product to cart');
                }
              } catch (error) {
                console.error('Error adding to cart:', error);
                alert('An error occurred while adding to cart.');
              }
            }}
          >
            <ShoppingCart size={24} strokeWidth={1.75} />
          </button>
        </div>
      </div>
    </div>
  );
}

/* ── Coupons Component ── */
function Coupons() {
  const coupons = [
    { discount: "7%", code: "B2G7" },
    { discount: "₹5%", code: "BKFIRST" },
    { discount: "10%", code: "B3G10" },
  ];
  return (
    <section className="coupons-section">
      {coupons.map((c, i) => (
        <div key={i} className="coupon-ticket">
          <div className="coupon-left">
            <span>FLAT <strong className="discount-amount">{c.discount}</strong> OFF*</span>
          </div>
          <div className="coupon-divider"></div>
          <div className="coupon-right">
            <span className="use-code">USE CODE:</span>
            <div className="coupon-code">{c.code}</div>
          </div>
        </div>
      ))}
    </section>
  );
}



/* ── Shop By Category Tabs Component ── */
function ShopByCategoryTabs() {
  const [activeTab, setActiveTab] = useState("Sarees");
  const tabs = ["Sarees", "Dress Materials"];

  const currentData = activeTab === "Sarees" ? SAREE_CATEGORIES : DRESS_MATERIALS;

  return (
    <section className="shop-category-section">
      <div className="section-header">
        <h2 className="dark">
          <SectionOrnament kind="lotus" />
          Shop By Category
          <SectionOrnament kind="lotus" reverse />
        </h2>
      </div>

      <div className="sbo-tabs">
        {tabs.map(tab => (
          <button 
            key={tab} 
            className={`sbo-tab ${activeTab === tab ? 'active' : ''}`}
            onClick={() => setActiveTab(tab)}
          >
            {tab}
          </button>
        ))}
      </div>

      <div className="product-grid">
        {currentData.map((cat, idx) => (
          <div key={cat.name + idx} className="category-card">
            <img src="/card-ornament.png" alt="" className="card-top-right-ornament" />
            <img src={cat.img} alt={cat.name} className="category-card-img" />
            <h4>{cat.name}</h4>
            <a href="#" className="btn-details">DETAILS</a>
          </div>
        ))}
      </div>
    </section>
  );
}

/* ── Floral Divider Component ── */
function FloralDivider() {
  return (
    <div className="floral-divider-container">
      <div className="floral-line"></div>
      <div className="floral-icon-wrapper">
        <img src="/divider-ornament.png" alt="Ornament" className="divider-ornament-img" />
      </div>
      <div className="floral-line"></div>
    </div>
  );
}

/* ── Customer Reviews Carousel ── */
const POPUP_OPEN_MS = 480;
const POPUP_CLOSE_MS = 400;
const POPUP_SHADOW = "0 30px 80px rgba(0, 0, 0, 0.5)";
const NO_SHADOW = "0 0 0 rgba(0, 0, 0, 0)";

const motionMs = (ms: number) =>
  window.matchMedia("(prefers-reduced-motion: reduce)").matches ? 0 : ms;

// Transform that makes an element laid out at `to` appear to sit at `from`
const flipFrom = (from: DOMRect, to: DOMRect) =>
  `translate(${from.left - to.left}px, ${from.top - to.top}px) scale(${from.width / to.width}, ${from.height / to.height})`;

function lockPageScroll(lock: boolean) {
  const { body, documentElement } = document;
  // pad by the scrollbar's width so the page doesn't shift when it disappears
  body.style.paddingRight = lock ? `${window.innerWidth - documentElement.clientWidth}px` : "";
  body.style.overflow = lock ? "hidden" : "";
}

function SocialMediaSection() {
  return (
    <section className="social-media-section" style={{ padding: '80px 0', width: '100%' }}>
      <div style={{ maxWidth: '1200px', margin: '0 auto', padding: '0 20px' }}>
        <div style={{ display: 'flex', justifyContent: 'center', marginBottom: '50px' }}>
           <div style={{ backgroundColor: '#fff', padding: '8px 20px', borderRadius: '30px', display: 'flex', alignItems: 'center', gap: '8px', fontSize: '14px', fontWeight: 'bold', boxShadow: '0 4px 15px rgba(0,0,0,0.05)', border: '1px solid rgba(0,0,0,0.05)' }}>
              Powered by <span style={{ color: '#f5a623' }}>trustmary</span>
           </div>
        </div>
        <div className="social-media-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '50px', alignItems: 'stretch' }}>
          
          {/* INSTAGRAM COLUMN */}
          <div className="instagram-mock" style={{ backgroundColor: '#fff', borderRadius: '16px', overflow: 'hidden', boxShadow: '0 10px 30px rgba(0,0,0,0.08)', border: '1px solid rgba(0,0,0,0.05)', display: 'flex', flexDirection: 'column', height: '100%' }}>
            <a href="https://www.instagram.com/official_pawarhandloom/?utm_source=ig_embed&ig_rid=ANSZzKd7RpOjbAQrbnZWD4-" target="_blank" rel="noopener noreferrer" style={{ textDecoration: 'none', color: 'inherit', display: 'block', flexShrink: 0 }}>
              <div style={{ padding: '24px', display: 'flex', alignItems: 'center', gap: '16px', borderBottom: '1px solid #f0f0f0', height: '114px' }}>
                <div style={{ width: '64px', height: '64px', borderRadius: '50%', background: 'linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%)', padding: '3px', flexShrink: 0 }}>
                   <img src="https://pawarhandloom.com/public/frontend/img/logo.png" style={{ width: '100%', height: '100%', borderRadius: '50%', backgroundColor: '#fff', objectFit: 'contain' }} alt="Profile" />
                </div>
                <div style={{ flexGrow: 1 }}>
                  <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <strong style={{ fontSize: '16px', fontWeight: '600' }}>official_pawarhandloom</strong>
                    <FaInstagram size={22} color="#bc1888" />
                  </div>
                  <div style={{ fontSize: '13px', color: '#666', marginTop: '4px' }}>PAWAR HANDLOOM® (Weaves of Madhya Pradesh)</div>
                  <div style={{ fontSize: '13px', color: '#888', marginTop: '4px', fontWeight: '500' }}>16.6K followers • 816 posts</div>
                </div>
              </div>
            </a>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: '4px', padding: '4px', flexGrow: 1 }}>
              {Array.from({ length: 6 }).map((_, i) => (
                <a href="https://www.instagram.com/official_pawarhandloom/?utm_source=ig_embed&ig_rid=ANSZzKd7RpOjbAQrbnZWD4-" target="_blank" rel="noopener noreferrer" key={i} className="insta-post-wrapper" style={{ backgroundColor: '#eee', position: 'relative', overflow: 'hidden', borderRadius: '4px', display: 'block', width: '100%', aspectRatio: '1/1' }}>
                  <img src={HERO_IMAGES[i % 3].desktop} style={{ width: '100%', height: '100%', objectFit: 'cover' }} alt="Insta post" className="insta-post-img" />
                  <div style={{ position: 'absolute', top: '8px', right: '8px', backgroundColor: 'rgba(0,0,0,0.5)', borderRadius: '50%', padding: '4px' }}>
                     <Play size={12} color="#fff" fill="#fff" />
                  </div>
                </a>
              ))}
            </div>
          </div>

          {/* YOUTUBE COLUMN */}
          <div className="youtube-mock" style={{ backgroundColor: '#fff', borderRadius: '16px', overflow: 'hidden', boxShadow: '0 10px 30px rgba(0,0,0,0.08)', border: '1px solid rgba(0,0,0,0.05)', display: 'flex', flexDirection: 'column', height: '100%' }}>
             <div style={{ padding: '24px', display: 'flex', alignItems: 'center', justifyContent: 'center', borderBottom: '1px solid #f0f0f0', flexShrink: 0, height: '114px' }}>
               <h3 style={{ fontSize: '18px', fontWeight: '600', display: 'flex', alignItems: 'center', gap: '12px', textTransform: 'uppercase', letterSpacing: '1px', color: '#333', margin: 0 }}>
                 PAWAR HANDLOOM <FaYoutube size={32} color="#FF0000" /> YOUTUBE CHANNEL
               </h3>
             </div>
             <div className="youtube-column-container" style={{ width: '100%', flexGrow: 1, backgroundColor: '#000', overflow: 'hidden', position: 'relative' }}>
               <iframe 
                 width="100%" 
                 height="100%"
                 style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%' }}
                 src="https://www.youtube.com/embed/LXb3EKWsInQ" 
                 title="YouTube video player" 
                 frameBorder="0" 
                 allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                 allowFullScreen>
               </iframe>
             </div>
          </div>

        </div>
      </div>
    </section>
  );
}


const DUMMY_REVIEWS = [
  { name: "Swetha Reddy", rating: 5, text: "The fabric feels soft and premium." },
  { name: "Anita Sharma", rating: 5, text: "Beautiful print and fast delivery!" },
  { name: "Priya Patel", rating: 4, text: "Loved the quality of the saree." },
  { name: "Kavya Singh", rating: 5, text: "Colors are exactly as shown in picture." },
];

function RotatingReviewPill() {
  const [index, setIndex] = useState(0);
  const [fade, setFade] = useState(true);

  useEffect(() => {
    const interval = setInterval(() => {
      setFade(false);
      setTimeout(() => {
        setIndex((prev) => (prev + 1) % DUMMY_REVIEWS.length);
        setFade(true);
      }, 300); // Wait for fade out
    }, 4000); // Rotate every 4 seconds

    return () => clearInterval(interval);
  }, []);

  const review = DUMMY_REVIEWS[index];

  return (
    <div className="header-review-pill" style={{ opacity: fade ? 1 : 0, transition: "opacity 0.3s ease" }}>
      <img src={`https://ui-avatars.com/api/?name=${review.name.replace(" ", "+")}&background=random`} alt={review.name} />
      <span>{review.name}</span>
      <span style={{ color: "#ddd" }}>|</span>
      <div className="stars">
        <Star size={12} fill="currentColor" /> {review.rating}
      </div>
      <span className="review-text">{review.text}</span>
    </div>
  );
}

/* ── Main Index Component ── */
export default function Index({ 
  serverSliders, 
  serverNewArrivals, 
  serverBestSellers,
  serverDressMaterial,
  serverSeeItLoveIt,
  serverCelebsLook
}: { 
  serverSliders?: any[];
  serverNewArrivals?: any[];
  serverBestSellers?: any[];
  serverDressMaterial?: any[];
  serverSeeItLoveIt?: any[];
  serverCelebsLook?: any[];
}) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [currentSlide, setCurrentSlide] = useState(0);
  const [showScrollTop, setShowScrollTop] = useState(false);
  const [openMobileSubmenu, setOpenMobileSubmenu] = useState<string | null>(null);
  const [isMobile, setIsMobile] = useState(false);
  const [cartCount, setCartCount] = useState(0);

  // Fetch cart data globally
  useEffect(() => {
    fetch("http://localhost:8080/cart/api", { credentials: "include" })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success' && data.cart && data.cart.items) {
          const count = data.cart.items.reduce((sum: number, item: any) => sum + parseInt(item.quantity, 10), 0);
          setCartCount(count);
        }
      })
      .catch(() => {
        // Backend (CodeIgniter on port 8080) is not running.
        // Cart count will default to 0 until the backend is started.
      });
  }, []);

  // Swipe / Drag state
  const [touchStart, setTouchStart] = useState<number | null>(null);
  const [touchEnd, setTouchEnd] = useState<number | null>(null);

  const minSwipeDistance = 50;

  useEffect(() => {
    const handleResize = () => setIsMobile(window.innerWidth <= 768);
    handleResize();
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  const activeSlides = serverSliders && serverSliders.length > 0 
    ? serverSliders.map(s => ({
        desktop: "http://localhost:8080/uploads/admin/slider_image/" + s.slider_image,
        mobile: "http://localhost:8080/uploads/admin/slider_image/" + s.mobile_slider_image,
        link: s.web_link || "#"
      }))
    : HERO_IMAGES;

  const displayNewArrivals = serverNewArrivals && serverNewArrivals.length > 0
    ? serverNewArrivals.map(p => ({
        name: p.product_name,
        id: p.id,
        img: p.cover_image ? "http://localhost:8080/" + p.cover_image : "/placeholder.png",
        originalPrice: p.actual_price,
        salePrice: p.offer_price,
        discount: "", // Calculate if needed
        badge: "NEW",
        readyToShip: true
      }))
    : NEW_ARRIVALS;

  const displayBestSellers = serverBestSellers && serverBestSellers.length > 0
    ? serverBestSellers.map(p => ({
        name: p.product_name,
        id: p.id,
        img: p.cover_image ? "http://localhost:8080/" + p.cover_image : "/placeholder.png",
        originalPrice: p.actual_price,
        salePrice: p.offer_price,
        discount: "", // Calculate if needed
        badge: "BEST SELLER",
        readyToShip: true
      }))
    : NEW_ARRIVALS;

  const displayDressMaterial = serverDressMaterial && serverDressMaterial.length > 0
    ? serverDressMaterial.map(p => ({
        name: p.product_name,
        id: p.id,
        img: p.cover_image ? "http://localhost:8080/" + p.cover_image : "/placeholder.png",
        originalPrice: p.actual_price,
        salePrice: p.offer_price,
        discount: "", 
        badge: "",
        readyToShip: true
      }))
    : DRESS_MATERIALS;

  const displaySeeItLoveIt = serverSeeItLoveIt && serverSeeItLoveIt.length > 0
    ? serverSeeItLoveIt.map(p => ({
        name: p.product_name,
        id: p.id,
        img: p.cover_image ? "http://localhost:8080/" + p.cover_image : "/placeholder.png",
        originalPrice: p.actual_price,
        salePrice: p.offer_price,
        discount: "", 
        badge: "",
        readyToShip: true
      }))
    : SEE_IT_LOVE_IT;

  const displayCelebsLook = serverCelebsLook && serverCelebsLook.length > 0
    ? serverCelebsLook.map(p => ({
        name: p.product_name,
        id: p.id,
        img: p.cover_image ? "http://localhost:8080/" + p.cover_image : "/placeholder.png",
        originalPrice: p.actual_price,
        salePrice: p.offer_price,
        discount: "", 
        badge: "",
        readyToShip: true
      }))
    : NEW_ARRIVALS;

  const handleTouchStart = (e: React.TouchEvent | React.MouseEvent) => {
    setTouchEnd(null);
    if ('targetTouches' in e) {
      setTouchStart(e.targetTouches[0].clientX);
    } else {
      setTouchStart((e as React.MouseEvent).clientX);
    }
  };

  const handleTouchMove = (e: React.TouchEvent | React.MouseEvent) => {
    if (touchStart === null) return;
    if ('targetTouches' in e) {
      setTouchEnd(e.targetTouches[0].clientX);
    } else {
      setTouchEnd((e as React.MouseEvent).clientX);
    }
  };

  const handleTouchEnd = () => {
    if (!touchStart || !touchEnd) {
      setTouchStart(null);
      setTouchEnd(null);
      return;
    }
    const distance = touchStart - touchEnd;
    const isLeftSwipe = distance > minSwipeDistance;
    const isRightSwipe = distance < -minSwipeDistance;

    if (isLeftSwipe) {
      setCurrentSlide((prev) => (prev + 1) % activeSlides.length);
    } else if (isRightSwipe) {
      setCurrentSlide((prev) => (prev - 1 + activeSlides.length) % activeSlides.length);
    }
    setTouchStart(null);
    setTouchEnd(null);
  };

  // Hero slider auto-advance
  useEffect(() => {
    const timer = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % activeSlides.length);
    }, 4000);
    return () => clearInterval(timer);
  }, [currentSlide, activeSlides.length]);

  // Scroll-to-top visibility
  useEffect(() => {
    const handleScroll = () => {
      setShowScrollTop(window.scrollY > 400);
    };
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  // Stop the page scrolling behind the open mobile menu
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
            <button className="mobile-menu-toggle" aria-label="Open menu" onClick={() => setMobileMenuOpen(true)}>
              <Menu size={24} />
            </button>
            <RotatingReviewPill />
          </div>

          {/* Center: Logo */}
          <div className="header-logo">
            <a href="/">
              <img src="https://pawarhandloom.com/public/frontend/img/logo.png" alt="Pawar Handloom" />
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
              <a href="#"><Heart size={20} /></a>
              <div className="user-dropdown">
                <a href="/login"><User size={20} /></a>
                <ul className="user-dropdown-menu">
                  <li><a href="/register">Resellers Register</a></li>
                  <li><a href="/login">Reseller Login</a></li>
                  <li><a href="/customer-register">Customer Register</a></li>
                  <li><a href="/customer-login">Customer Login</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        {/* Navigation Row */}
        <div className="header-nav-row">
          <nav>
            <ul className="main-nav">
              <li><a href="/shop/6">New Arrival</a></li>
              <li><a href="/shop/7">Best Seller</a></li>
              <li><a href="#">Same Day Dispatch</a></li>
              <li>
                <a href="/shop/2">Sarees</a>
              </li>
              <li><a href="/shop/3">Dress Materials</a></li>
              <li><a href="/shop/2">Shop All</a></li>
              <li>
                <a href="#">Shop by Collection <ChevronDown size={14} style={{ marginTop: 2 }} /></a>
                <ul className="dropdown">
                  {COLLECTION_MENU.map((item) => (
                    <li key={item.name}>
                      <a href={item.href}>
                        {item.name}
                        {item.children && <ChevronRight size={12} style={{ float: "right", marginTop: 3 }} />}
                      </a>
                      {item.children && (
                        <ul className="sub-dropdown">
                          {item.children.map((sub) => (
                            <li key={sub.name}>
                              <a href={sub.href}>
                                {sub.name}
                                {"children" in sub && sub.children && (
                                  <ChevronRight size={12} style={{ float: "right", marginTop: 3 }} />
                                )}
                              </a>
                            </li>
                          ))}
                        </ul>
                      )}
                    </li>
                  ))}
                </ul>
              </li>
              <li><a href="#" style={{ color: "#ac4024" }}><Leaf size={14} style={{ marginRight: 4 }}/> Offers</a></li>
              <li><a href="#" style={{ color: "#ac4024" }}><Star size={14} style={{ marginRight: 4 }}/> Sale</a></li>
              <li><a href="/about">About</a></li>
            </ul>
          </nav>
        </div>
      </header>

      {/* ══════════ MOBILE NAV ══════════ */}
      {mobileMenuOpen && (
        <>
          <div className="mobile-nav-overlay" onClick={() => setMobileMenuOpen(false)} />
          <div className="mobile-nav">
            <div className="mobile-nav-head">
              <img src="https://pawarhandloom.com/public/frontend/img/logo.png" alt="Pawar Handloom" />
              <button aria-label="Close menu" onClick={() => setMobileMenuOpen(false)} style={{ background: "none", border: "none", cursor: "pointer" }}>
                <X size={24} />
              </button>
            </div>
            <div className="mobile-nav-search">
              <Search size={16} />
              <AnimatedSearchInput />
            </div>
            <ul>
              <li><a href="/shop/6">New Arrival</a></li>
              <li><a href="/shop/7">Best Seller</a></li>
              <li><a href="#">Same Day Dispatch</a></li>
              <li><a href="/shop/2">Sarees</a></li>
              <li><a href="/shop/3">Dress Materials</a></li>
              <li><a href="/shop/2">Shop All</a></li>
              <li>
                <a
                  href="#"
                  onClick={(e) => {
                    e.preventDefault();
                    setOpenMobileSubmenu(openMobileSubmenu === "collection" ? null : "collection");
                  }}
                  style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}
                >
                  Collection
                  <ChevronDown size={16} style={{ transform: openMobileSubmenu === "collection" ? "rotate(180deg)" : "none", transition: "transform 0.3s" }} />
                </a>
                {openMobileSubmenu === "collection" && (
                  <ul style={{ paddingLeft: 15 }}>
                    {COLLECTION_MENU.map((item) => (
                      <li key={item.name}><a href={item.href}>{item.name}</a></li>
                    ))}
                  </ul>
                )}
              </li>
              <li><a href="#" className="mobile-nav-highlight">Offers</a></li>
              <li><a href="#" className="mobile-nav-highlight">Sale</a></li>
              <li><a href="/about">About Us</a></li>
              <li><a href="/gallery">Gallery</a></li>
              <li><a href="/contact">Contact</a></li>
              <li><a href="/review">Review</a></li>
            </ul>
            <div className="mobile-nav-account">
              <a href="/CustomerLogin">Customer Login</a>
              <a href="/CustomerRegister">Customer Register</a>
              <a href="/login">Reseller Login</a>
              <a href="/register">Resellers Register</a>
            </div>
          </div>
        </>
      )}

      {/* ══════════ HERO SECTION ══════════ */}
      <section 
        className="hero-slider"
        onTouchStart={handleTouchStart}
        onTouchMove={handleTouchMove}
        onTouchEnd={handleTouchEnd}
        onMouseDown={handleTouchStart}
        onMouseMove={handleTouchMove}
        onMouseUp={handleTouchEnd}
        onMouseLeave={handleTouchEnd}
        style={{ cursor: touchStart !== null ? 'grabbing' : 'grab' }}
      >
        <div className="hero-slider-track" style={{ transform: `translateX(-${currentSlide * 100}%)` }} onDragStart={(e) => e.preventDefault()}>
          {activeSlides.map((slide, i) => (
            <div key={i} className="hero-slide" style={{ userSelect: 'none' }}>
              <picture>
                <source media="(max-width: 768px)" srcSet={slide.mobile} />
                <img src={slide.desktop} alt={`Slide ${i + 1}`} className="hero-slide-img" draggable={false} />
              </picture>
            </div>
          ))}
        </div>
        {activeSlides.length > 1 && (
          <>
            <button 
              className="slider-nav-btn prev-btn" 
              onClick={() => setCurrentSlide((prev) => (prev - 1 + activeSlides.length) % activeSlides.length)}
            >
              <ChevronLeft size={24} />
            </button>
            <button 
              className="slider-nav-btn next-btn" 
              onClick={() => setCurrentSlide((prev) => (prev + 1) % activeSlides.length)}
            >
              <ChevronRight size={24} />
            </button>
          </>
        )}
      </section>

      {/* ══════════ SHOP BY CATEGORY WITH TABS ══════════ */}
      <ShopByCategoryTabs />

      {/* ══════════ COUPONS ══════════ */}
      <Coupons />

      {/* ══════════ FLORAL DIVIDER ══════════ */}
      <FloralDivider />

      {/* ══════════ SUB-CATEGORY ICONS ══════════ */}
      <section className="subcategory-icons">
        {SUBCATEGORIES.map((cat) => (
          <a key={cat.name} href="#" className="subcategory-item">
            <img src={cat.img} alt={cat.name} />
            <span>{cat.name}</span>
          </a>
        ))}
      </section>

      {/* ══════════ NEW ARRIVALS ══════════ */}
      <section className="new-arrivals-section">
        <div className="section-header">
          <h2>
            <SectionOrnament kind="sparkle" />
            <span style={{ color: "#ac4024" }}>New Arrivals</span>
            <SectionOrnament kind="sparkle" reverse />
          </h2>
        </div>
        <div className="product-grid">
          {displayNewArrivals.map((product, i) => (
            <ProductCard key={i} {...product} />
          ))}
        </div>
        <div style={{ textAlign: "center" }}>
          <a href="/shop/6" className="btn-view-all">VIEW ALL</a>
        </div>
      </section>



      <FloralDivider />

      {/* ══════════ DRESS MATERIALS ══════════ */}
      <section className="dress-materials-section">
        <div className="section-header">
          <h2>
            <SectionOrnament kind="charkha" />
            <span style={{ color: "#333" }}>Dress Materials</span>
            <SectionOrnament kind="charkha" reverse />
          </h2>
        </div>
        <div className="product-grid">
          {displayDressMaterial.map((product, i) => (
            <ProductCard key={i} {...product} />
          ))}
        </div>
        <div style={{ textAlign: "center" }}>
          <a href="/shop/3" className="btn-view-all">VIEW ALL</a>
        </div>
      </section>

      <FloralDivider />

      {/* ══════════ BEST SELLERS ══════════ */}
      <section className="best-sellers-section">
        <div className="section-header">
          <h2 className="dark">
            <SectionOrnament kind="rosette" />
            Best Sellers
            <SectionOrnament kind="rosette" reverse />
          </h2>
        </div>
        <div className="product-grid">
          {displayBestSellers.map((product, i) => (
            <ProductCard key={i} {...product} />
          ))}
        </div>
      </section>

      <FloralDivider />

      {/* ══════════ SEE IT. LOVE IT. OWN IT. ══════════ */}
      <section className="see-it-love-it-section">
        <div className="section-header">
          <h2 className="dark" style={{ fontStyle: "italic" }}>
            <SectionOrnament kind="hearts" />
            See It. Love It. Own It.
            <SectionOrnament kind="hearts" reverse />
          </h2>
        </div>
        <div className="silo-marquee-container">
          <div className="silo-marquee-inner">
            {/* Group 1 — multiply items so it's always wider than the screen */}
            <div className="silo-marquee-group">
              {[...displaySeeItLoveIt, ...displaySeeItLoveIt, ...displaySeeItLoveIt, ...displaySeeItLoveIt].map((product, i) => (
                <div className="silo-marquee-item" key={i}>
                  <ProductCard {...product} />
                </div>
              ))}
            </div>
            {/* Group 2 — identical duplicate for seamless loop */}
            <div className="silo-marquee-group" aria-hidden="true">
              {[...displaySeeItLoveIt, ...displaySeeItLoveIt, ...displaySeeItLoveIt, ...displaySeeItLoveIt].map((product, i) => (
                <div className="silo-marquee-item" key={`d-${i}`}>
                  <ProductCard {...product} />
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      <FloralDivider />

      {/* ══════════ CELEBS LOOK ══════════ */}
      <section className="celebs-look-section">
        <div className="section-header">
          <h2>
            <SectionOrnament kind="sun" />
            <span style={{ color: "#ac4024" }}>For Every Occasion</span>
            <SectionOrnament kind="sun" reverse />
          </h2>
        </div>
        <div className="celebs-grid">
          {displayCelebsLook.map((product, i) => (
            <div key={i} className="celebs-card">
              <img src="/card-ornament.png" alt="" className="card-top-right-ornament" />
              <img src={product.img} alt={`Celebs ${i + 1}`} />
            </div>
          ))}
        </div>
        <div style={{ textAlign: "center" }}>
          <a href="/shop/8" className="btn-view-all">VIEW ALL</a>
        </div>
      </section>

      <FloralDivider />

      {/* ══════════ SOCIAL MEDIA ══════════ */}
      <SocialMediaSection />

      <FloralDivider />

      {/* ══════════ ABOUT US ══════════ */}
      <section className="about-section">
        <div className="about-text">
          <h2>Pawar Handloom</h2>
          <p>
            Explore our exquisite collection of Maheshwari, Chanderi and Handblock Printed Sarees and Dress Material inspired by the royal heritage weaves of Madhya Pradesh, India.
          </p>
          <p>
            Pawar Handloom is our ancestry brand from 5th generation. I am Piyush Kailash N.K. Pawar extended my 5th ancestral business to the next level. Initially my great great grandfather brought by Former Queen of Malwa kingdom Ahilya Mata as an artisian to Maheshwar. Back then my grandfather named "Mr. Nathusa Kevalram Pawar" established "Pawar Handloom" as a traditional clothing brand of Maheshwari & Induri Sarees since 90 years back in Maheshwar, Madhya Pradesh.
          </p>
          <a href="/about" className="btn-read-more">
            💬 READ MORE
          </a>
        </div>
        <div className="about-image">
          <img
            src="/ahilyafort.jpg.jpeg"
            alt="The carved gateway of Ahilya Fort, Maheshwar"
          />
        </div>
      </section>

      {/* ══════════ FEATURES BAR MARQUEE ══════════ */}
      <section className="features-bar-marquee">
        <div className="marquee-container-horizontal">
          <div className="marquee-content-horizontal">
            {Array.from({ length: 6 }).map((_, i) => (
              <div key={i} className="marquee-group-horizontal">
                <div className="feature-marquee-item">
                  Handcrafted in Maheshwar
                </div>
                <div className="feature-marquee-item">
                  <Truck size={20} />
                  Free Shipping across india
                </div>
                <div className="feature-marquee-item">
                  <Ticket size={20} />
                  COD Available
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>





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
              Handwoven sarees &amp; suits straight from the looms of Maheshwar, Madhya Pradesh.
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
                <a href="mailto:support@pawarhandloom.com">support@pawarhandloom.com</a>
              </li>
              <li>
                <MapPin size={15} />
                <span>Pawar Handloom, Maheshwar, Madhya Pradesh - 451224</span>
              </li>
            </ul>

            <div className="footer-social">
              <a href="#" aria-label="Facebook"><FaFacebook size={16} /></a>
              <a href="#" aria-label="Instagram"><FaInstagram size={16} /></a>
              <a href="#" aria-label="YouTube"><FaYoutube size={16} /></a>
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
              <li><a href="/shop/6">New Arrival</a></li>
              <li><a href="#">Same Day Dispatch</a></li>
              <li><a href="/shop/2">Lehenga</a></li>
              <li><a href="/shop/3">Suit Sets</a></li>
              <li><a href="/shop/3">Dresses</a></li>
              <li><a href="#">Can Can Skirt</a></li>
              <li><a href="#">Lehenga Bundle</a></li>
              <li><a href="#">Banarasi Dresses</a></li>
              <li><a href="#">Lehengas Under 7999</a></li>
              <li><a href="#">Half Saree Under 6999</a></li>
            </ul>
          </div>

          {/* Column 2 */}
          <div className="footer-col">
            <h4>MY ACCOUNT</h4>
            <ul>
              <li><a href="#">My Account</a></li>
              <li><a href="/register">Register</a></li>
              <li><a href="/login">Login</a></li>
              <li><a href="#">View Order</a></li>
            </ul>
          </div>

          {/* Column 3 */}
          <div className="footer-col">
            <h4>CUSTOMER SERVICE</h4>
            <ul>
              <li><a href="#">Terms & Condition</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Shipping Policy</a></li>
              <li><a href="#">Return & Exchange Policy</a></li>
              <li><a href="#">Sitemap</a></li>
            </ul>
          </div>

          {/* Column 4 */}
          <div className="footer-col">
            <h4>INFORMATION</h4>
            <ul>
              <li><a href="#">Blogs</a></li>
              <li><a href="/about">About Us</a></li>
              <li><a href="/contact">Contact Us</a></li>
              <li><a href="#">Wholesale Inquiry</a></li>
              <li><a href="#">Franchise Inquiry</a></li>
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
      <a href="/review" className="reviews-tab" style={{ textDecoration: 'none' }}>
        <span>★</span> Reviews
      </a>
      <a href="https://wa.me/919630504663" className="float-whatsapp" target="_blank" rel="noopener noreferrer">
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