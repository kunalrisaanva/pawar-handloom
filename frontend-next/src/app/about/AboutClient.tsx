"use client";
import React from "react";
import SharedLayout from "@/components/SharedLayout";
import Link from "next/link";

const legacyData = [
  {
    title: "OUR STORY: A LEGACY OF HERITAGE, HEIRLOOM AND CRAFTSMANSHIP",
    text: (
      <>
        <p style={{ marginBottom: "16px", fontWeight: "500", fontSize: "0.95rem", color: "#333", fontStyle: "italic" }}>
          &quot;Pawar Handloom; our story is one of passion, dedication, and heritage. For over 5 generations, we&apos;ve perfected handloom weaving, crafting exquisite Maheshwari, Induri and Chanderi sarees that reflect Madhya Pradesh&apos;s rich cultural landscape.&quot;
        </p>
        <p style={{ marginBottom: "16px" }}>
          In the heart of Maheshwar, a small town in Madhya Pradesh, there existed a family bound by tradition, love, and a shared passion for handloom weaving. The Pawar family, with a legacy spanning over 5 generations, had been entrusted with the responsibility of preserving the art of Maheshwari saree weaving.
        </p>
        <p style={{ marginBottom: "16px" }}>
          It all began with the legendary Queen Ahilya Bai Holkar, who brought the artisans to Maheshwar and encouraged them to weave their magic. The Pawar family, with their exceptional skill and dedication, became the custodians of this ancient craft.
        </p>
        <p>
          Pawar Handloom&apos;s legacy began when our great-great-grandfather was invited by Queen Ahilya Mata of the Holkar Dynasty to Maheshwar from Satara, Maharashtra. Our organization was formally founded by Nathusa Kevalram Pawar in the early 20th century, with a mission to preserve and promote traditional handloom weaving, spanning multiple generations.
        </p>
      </>
    ),
    image: "/la01.jpeg",
  },
  {
    title: "THE LEGACY CONTINUES",
    text: (
      <>
        <p style={{ marginBottom: "16px" }}>
          Pawar Handloom is dedicated to preserving India&apos;s rich textile heritage through exquisite handloom weaves of Madhya Pradesh, embodying a legacy of tradition, love, and craftsmanship passed down through generations.
        </p>
        <p style={{ marginBottom: "16px" }}>
          As the years passed, the family grew, and the tradition continued. Mr. Kailash Pawar, son of late Shree Nathusa Kevalram Pawar, played a pivotal role in carrying forward the family&apos;s legacy. He worked tirelessly to perfect the craft, passing on his expertise to the next generation and establishing Pawar Handloom as a renowned name in handloom weaving, synonymous with excellence and tradition.
        </p>
        <p style={{ marginBottom: "16px" }}>
          Today, the Pawar family Mr. Kailash Pawar with his two sons continues to weave their magic, creating exquisite Maheshwari sarees that tell the story of their heritage and history. Each thread, each motif, and each design is a testament to their dedication to preserving their cultural legacy.
        </p>
        <p>
          The Pawar Handloom is a story of Parivar, Virasat, and Itihaas - a story of a family bound by tradition, love, and a shared passion for handloom weaving. It&apos;s a story that continues to inspire and weave its way into the hearts of those who appreciate the beauty of Indian textiles.
        </p>
      </>
    ),
    image: "/la02.jpeg",
  },
  {
    title: "LEGACY TAKES ROOT IN INDORE",
    text: (
      <>
        <p style={{ marginBottom: "16px" }}>
          Today, the long generation of our family, Piyush Kailash N.K. Pawar is proud to carry forward the legacy of Pawar Handloom to Indore. With a commitment to excellence and a passion for innovation, we strive to blend traditional techniques with modern elegance, creating sarees that are both timeless and contemporary.
        </p>
        <p style={{ marginBottom: "16px" }}>
          Under Mr. Piyush Pawar&apos;s (younger son of Mr. Kailash Nathusa Kevalram Pawar) leadership, Pawar Handloom expanded its operations to Indore. It&apos;s truly commendable how the brand has expanded its operations from a small one BHK flat to becoming a reputable handloom store at Rishi Apartment, Rajendra Nagar. The business has been thriving ever since, offering a wide range of handloom products, including Maheshwari sarees, Chanderi sarees, and handblock-printed sarees & dress materials.
        </p>
        <p>
          Pawar Handloom has gained recognition as one and only authentic reputable handloom store in Indore, with a strong online presence and listings on platforms like Just dial, TradeIndia and IndiaMART. The brand is committed to providing high-quality products and excellent customer service, building long-lasting relationships with its customers.
        </p>
      </>
    ),
    image: "/la03.jpeg",
  },
  {
    title: "ONE AND ONLY AUTHENTIC BRANCH IN INDORE",
    text: (
      <>
        <p style={{ marginBottom: "16px" }}>
          Pawar Handloom is a renowned manufacturer and wholesaler of exquisite Maheshwari and Chanderi sarees, with a legacy spanning over generation of weaving passed down with pride. Our journey began in Maheshwar, Madhya Pradesh, where our ancestors were artisans brought from Dist. Satara, Maharashtra by the legendary Queen Ahilya Bai Holkar to preserve the traditional craft of handloom weaving. Today, we operate from Indore also, as two prominent locations: Bazar Chowk, Maheshwar, and Rajendra Nagar, Indore. Our collections include stunning Maheshwari, Chanderi, and handblock-printed sarees and dress materials, such as bagh, batik, indigo, kalamkari, dabu, ajrakh, Indonesian, varli, and more. These are intricately woven with precision and love, reflecting the rich cultural heritage of our region.
        </p>
        <p>
          With a strong presence in the market, we cater to customers across India and offer our products at trustable prices. Our team is dedicated to ensuring customer satisfaction, and we take pride in our craftsmanship and commitment to quality.
        </p>
      </>
    ),
    image: "/la04.jpeg",
  },
  {
    title: "WHY YOU CHOOSE PAWAR HANDLOOM",
    text: (
      <>
        <ul style={{ paddingLeft: "20px", display: "flex", flexDirection: "column", gap: "15px", listStyleType: "disc", margin: "0" }}>
          <li><strong>Rich Heritage and Traditional Craftsmanship:</strong> With over more than 90 years tradition of weaving, Pawar Handloom brings forth the traditional craftsmanship of Maheshwari and Chanderi handloom weaving, ensuring high-quality, handmade products that reflect India&apos;s rich cultural heritage.</li>
          <li><strong>Wide Range of Handloom Products:</strong> Pawar Handloom offers a diverse collection of Maheshwari, Chanderi, and handblock-printed sarees and dress materials, including bagh, batik, indigo, kalamkari, dabu, ajrakh, Indonesian, varli, and more, catering to various tastes and preferences.</li>
          <li><strong>Authenticity and Quality Guarantee:</strong> As a multi-generational family business, Pawar Handloom is committed to providing authentic, high-quality products that reflect the true essence of traditional handloom craftsmanship, ensuring customer satisfaction and trust.</li>
          <li><strong>Manufacturing Prices and Customer-Centric Approach:</strong> Pawar Handloom offers competitive wholesale prices and focuses on building long-term relationships with customers, providing personalized attention and support to ensure a seamless shopping experience.</li>
        </ul>
        <p style={{ marginTop: "20px", fontWeight: "500", color: "#333" }}>
          These USPs highlight Pawar Handloom&apos;s unique strengths and value proposition, setting it apart from other handloom stores.
        </p>
      </>
    ),
    image: "/la05.jpeg",
  },
  {
    title: "JOIN OUR STORY",
    text: (
      <>
        <h3 style={{ fontSize: "1.1rem", fontWeight: "700", marginBottom: "10px", color: "#b8860b", textTransform: "uppercase" }}>PAWAR HANDLOOM</h3>
        <p style={{ fontWeight: "600", marginBottom: "8px", color: "#222" }}>MFR & SELLER OF PURE MAHESHWARI & CHANDERI MATERIAL</p>
        <p style={{ marginBottom: "20px", fontStyle: "italic", color: "#666" }}>Seller of Pure Heritage of Maheshwari & Different Hand Block Printing Authentic</p>
        <p>
          As we continue to weave our story, we invite you to join us on this journey. Explore our collection, experience the beauty of handloom weaving, and be a part of our legacy. Together, let&apos;s preserve and promote the art of handloom weaving for generations to come.
        </p>
      </>
    ),
    image: "/la06.jpeg",
  }
];

export default function AboutClient() {
  return (
    <SharedLayout>
      {/* Existing About Hero Section */}
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
        <div style={{
          position: "absolute",
          top: 0, left: 0, right: 0, bottom: 0,
          backgroundColor: "rgba(0,0,0,0.4)"
        }}></div>
        
        <h1 style={{ 
          position: "relative",
          color: "#fff", 
          fontSize: "3.5rem", 
          fontFamily: "var(--font-serif)",
          letterSpacing: "2px",
          textShadow: "2px 2px 4px rgba(0,0,0,0.6)",
          fontWeight: "700"
        }}>
          About Us
        </h1>
      </div>

      {/* Original About Content */}
      <div className="about-content" style={{ padding: "100px 20px", maxWidth: "1300px", margin: "0 auto" }}>
        <div style={{ 
          display: "grid", 
          gridTemplateColumns: "repeat(auto-fit, minmax(300px, 1fr))", 
          gap: "80px", 
          alignItems: "center" 
        }}>
          <div style={{ width: "100%", position: "relative", padding: "20px" }}>
            <div style={{
              position: "absolute",
              top: 0, left: 0, right: "40px", bottom: "40px",
              backgroundColor: "#f0e6d2",
              borderRadius: "16px",
              zIndex: -1
            }}></div>
            <img 
              src="https://pawarhandloom.com/public/frontend/img/collection/collection-1.png" 
              alt="Pawar Handloom Store" 
              style={{ width: "100%", height: "auto", borderRadius: "16px", boxShadow: "0 25px 50px -12px rgba(0,0,0,0.25)" }} 
            />
          </div>
          <div style={{ textAlign: "justify" }}>
            <h2 style={{ fontFamily: "var(--font-sans)", fontSize: "2.4rem", color: "#222", marginBottom: "24px", fontWeight: "800", letterSpacing: "-0.5px" }}>
              About Pawar Handloom
            </h2>
            <div style={{ width: "60px", height: "4px", backgroundColor: "#b8860b", marginBottom: "30px" }}></div>
            <p style={{ fontSize: "1.1rem", lineHeight: "1.8", color: "#555", marginBottom: "20px", fontWeight: "400" }}>
              At present, we preserve the highest level of skill in traditional & contemporary woven textiles from Madhya Pradesh. As a tribute to the traditions of Indian classicism and in commemoration to push make in India, Pawar Handloom offers the most reputable & trusted store that exhibits the highest level of technical and aesthetic quality and pays homage to the pinnacles of the past.
            </p>
            <p style={{ fontSize: "1.1rem", lineHeight: "1.8", color: "#555", fontWeight: "400" }}>
              It is an honour for Pawar Handloom by Mr. Piyush K.N.K. Pawar to exhibit style of weaving techniques known as cloth of gold threads served as the ultimate inspiration for the woven saris which are classified on the basis of their borders or the patterns in them like Maheshwar bugdi kinar, zari patti, rui phool kinar, phool kinar, chatai kinar, V kinar, kahar kinar, bajuband kinar (narmada wave pattern in between silver and golden zari) and the like on our website and also revived the art of Handloom Weaving by calling in expert karigars.
            </p>
          </div>
        </div>
      </div>

      {/* New Legacy Section - Stacking Sticky Cards */}
      <div style={{ backgroundColor: "#faf8f5", padding: "100px 20px 140px", borderTop: "1px solid #eaeaea", position: "relative" }}>
        <div style={{ maxWidth: "1200px", margin: "0 auto" }}>
          
          <div style={{ textAlign: "center", marginBottom: "100px" }}>
            <span style={{ color: "#b8860b", fontWeight: "600", letterSpacing: "2px", textTransform: "uppercase", fontSize: "0.9rem" }}>Our History</span>
            <h2 style={{ fontSize: "2.4rem", color: "#222", fontFamily: "var(--font-serif)", fontWeight: "700", margin: "16px 0 24px", textTransform: "uppercase", letterSpacing: "1px" }}>
              A Legacy of Craftsmanship
            </h2>
            <div style={{ width: "80px", height: "4px", backgroundColor: "#b8860b", margin: "0 auto" }}></div>
            <p style={{ marginTop: "24px", color: "#666", fontSize: "0.95rem", maxWidth: "700px", margin: "24px auto 0", lineHeight: "1.6" }}>
              Discover the generations of tradition, passion, and artistic mastery that define the essence of Pawar Handloom.
            </p>
          </div>

          <div className="legacy-stack-container" style={{ position: "relative" }}>
            {legacyData.map((item, index) => (
              <div 
                key={index} 
                className="legacy-card"
                style={{ 
                  position: "sticky",
                  // The calc creates the beautiful stepped overlap effect as you scroll
                  top: `calc(80px + ${index * 20}px)`,
                  backgroundColor: "#fff",
                  borderRadius: "32px",
                  padding: "60px",
                  boxShadow: "0 -20px 40px rgba(0,0,0,0.08)",
                  border: "1px solid rgba(0,0,0,0.04)",
                  display: "flex", 
                  flexDirection: index % 2 === 0 ? "row" : "row-reverse", 
                  flexWrap: "wrap",
                  alignItems: "center", 
                  gap: "60px",
                  zIndex: index,
                  marginBottom: "40px", // space between cards before they stack
                  transition: "all 0.3s ease"
                }}
              >
                <div style={{ flex: "1 1 400px", minWidth: "300px" }}>
                  <div className="legacy-image-wrapper" style={{ 
                    position: "relative", 
                    borderRadius: "24px", 
                    overflow: "hidden", 
                    boxShadow: "0 15px 35px rgba(0,0,0,0.1)",
                  }}>
                    <img
                      src={item.image}
                      alt={item.title}
                      className="legacy-image"
                      style={{ 
                        width: "100%", 
                        height: "auto", 
                        maxHeight: "450px", 
                        objectFit: "cover",
                        display: "block",
                        transition: "transform 0.7s ease"
                      }}
                    />
                  </div>
                </div>

                <div style={{ flex: "1 1 450px", minWidth: "300px", textAlign: "justify" }}>
                  <div style={{ display: "flex", alignItems: "center", gap: "20px", marginBottom: "24px" }}>
                    <span style={{ 
                      display: "inline-block", 
                      color: "#b8860b", 
                      fontSize: "2.5rem", 
                      fontWeight: "900", 
                      opacity: "0.15", 
                      lineHeight: "1", 
                    }}>
                      0{index + 1}
                    </span>
                    <h3 style={{ 
                      fontSize: "1.5rem", 
                      color: "#222", 
                      fontFamily: "var(--font-serif)", 
                      fontWeight: "700",
                      lineHeight: "1.3",
                      margin: 0
                    }}>
                      {item.title}
                    </h3>
                  </div>
                  <div style={{ 
                    fontSize: "0.9rem", 
                    lineHeight: "1.8", 
                    color: "#555",
                    fontWeight: "400"
                  }}>
                    {item.text}
                  </div>
                </div>
              </div>
            ))}
          </div>

        </div>
      </div>
      
      {/* Mobile Styles for the Sticky Stacking Cards */}
      <style dangerouslySetInnerHTML={{__html: `
        @media (max-width: 992px) {
          .legacy-card {
            flex-direction: column !important;
            gap: 40px !important;
            padding: 40px 24px !important;
            margin-bottom: 30px !important;
            border-radius: 24px !important;
          }
          .legacy-card > div {
            flex: 1 1 auto !important;
            width: 100%;
          }
          .legacy-image-wrapper img {
            max-height: 350px !important;
          }
        }
        
        .legacy-image-wrapper:hover .legacy-image {
          transform: scale(1.05);
        }
      `}} />

    </SharedLayout>
  );
}
