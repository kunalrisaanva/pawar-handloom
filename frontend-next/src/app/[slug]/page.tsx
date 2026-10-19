import React from 'react';
import SharedLayout from '@/components/SharedLayout';

export default async function SlugPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  return (
    <SharedLayout>
      <section className="slug-hero-section" style={{ width: '100%', margin: '0', padding: '0' }}>
        <img 
          src="/shop.png" 
          alt="Shop Hero Image" 
          style={{ width: '100%', height: 'auto', display: 'block', objectFit: 'cover' }} 
        />
      </section>
      
      <div className="product-details-container" style={{ padding: '4rem 5%', maxWidth: '1200px', margin: '0 auto', display: 'flex', flexWrap: 'wrap', gap: '3rem' }}>
        {/* Left: Images Section */}
        <div className="product-images" style={{ flex: '1 1 400px' }}>
          <img 
            src="/coll01.png" 
            alt="Product Main" 
            style={{ width: '100%', height: 'auto', borderRadius: '8px', boxShadow: '0 4px 12px rgba(0,0,0,0.1)' }} 
          />
          <div style={{ display: 'flex', gap: '1rem', marginTop: '1rem' }}>
            <img src="/coll.png" alt="Thumb 1" style={{ width: '80px', height: '80px', objectFit: 'cover', borderRadius: '4px', cursor: 'pointer', border: '2px solid #ac4024' }} />
            <img src="/coll01.png" alt="Thumb 2" style={{ width: '80px', height: '80px', objectFit: 'cover', borderRadius: '4px', cursor: 'pointer', border: '1px solid #ddd' }} />
          </div>
        </div>

        {/* Right: Product Details Section */}
        <div className="product-details" style={{ flex: '1 1 400px' }}>
          <h1 style={{ fontSize: '2.5rem', marginBottom: '0.5rem', textTransform: 'capitalize', color: '#333', fontFamily: 'var(--font-serif)' }}>
            {slug.replace(/-/g, ' ')}
          </h1>
          <p style={{ fontSize: '1.5rem', color: '#ac4024', fontWeight: 'bold', marginBottom: '1.5rem' }}>₹4,050.00 <span style={{ textDecoration: 'line-through', color: '#999', fontSize: '1rem', fontWeight: 'normal' }}>₹4,500.00</span></p>
          
          <h3 style={{ fontSize: '1.2rem', marginBottom: '0.5rem', borderBottom: '1px solid #eee', paddingBottom: '0.5rem' }}>Product Details</h3>
          <p style={{ color: '#555', fontSize: '1rem', lineHeight: '1.8', marginBottom: '2rem' }}>
            Discover our exclusive {slug.replace(/-/g, ' ')} collection, featuring traditional artistry and premium quality. Handwoven with care, this beautiful piece is perfect for any special occasion, giving you a royal look.
          </p>

          <button style={{ backgroundColor: '#ac4024', color: '#fff', border: 'none', padding: '1rem 2rem', fontSize: '1.1rem', borderRadius: '4px', cursor: 'pointer', width: '100%', maxWidth: '300px', display: 'flex', justifyContent: 'center', alignItems: 'center', gap: '0.5rem' }}>
            Add to Cart
          </button>
        </div>
      </div>
    </SharedLayout>
  );
}
