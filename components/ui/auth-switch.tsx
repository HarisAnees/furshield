"use client";

import { useState, type FormEvent } from "react";

export default function AuthSwitch() {
  const [isSignUp, setIsSignUp] = useState(false);

  const onSubmit = (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
  };

  return (
    <div className="auth-switch">
      <style>{`
        .auth-switch {
          min-height: 100vh;
          background-color: #040907;
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
          color: #ffffff;
        }

        .auth-switch *,
        .auth-switch *::before,
        .auth-switch *::after {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
        }

        .auth-container {
          position: relative;
          width: 100%;
          background-color: #ffffff;
          min-height: 100vh;
          overflow: hidden;
        }

        .forms-container {
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
        }

        .signin-signup {
          position: absolute;
          top: 50%;
          transform: translate(-50%, -50%);
          left: 75%;
          width: 50%;
          transition: 1s 0.7s ease-in-out;
          display: grid;
          grid-template-columns: 1fr;
          z-index: 5;
        }

        .auth-form {
          display: flex;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          padding: 0rem 5rem;
          transition: all 0.2s 0.7s;
          overflow: hidden;
          grid-column: 1 / 2;
          grid-row: 1 / 2;
        }

        .auth-form.sign-up-form {
          opacity: 0;
          z-index: 1;
        }

        .auth-form.sign-in-form {
          z-index: 2;
        }

        .auth-title {
          font-size: 2.2rem;
          color: #091a13;
          margin-bottom: 10px;
          font-weight: 800;
          letter-spacing: -0.02em;
        }

        .input-field {
          max-width: 380px;
          width: 100%;
          background-color: #f0fdf4;
          margin: 10px 0;
          height: 55px;
          border-radius: 55px;
          display: grid;
          grid-template-columns: 15% 85%;
          padding: 0 0.4rem;
          position: relative;
          border: 1px solid #bbf7d0;
          transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-field:focus-within {
          border-color: #10b981;
          box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .input-field i {
          text-align: center;
          line-height: 55px;
          color: #059669;
          transition: 0.5s;
          font-size: 1.1rem;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .input-field input,
        .input-field select {
          background: none;
          outline: none;
          border: none;
          line-height: 1;
          font-weight: 600;
          font-size: 1.05rem;
          color: #091a13;
          width: 100%;
          font-family: inherit;
        }

        .input-field input::placeholder {
          color: #94a3b8;
          font-weight: 500;
        }

        .social-text {
          padding: 0.7rem 0;
          font-size: 1rem;
          color: #475569;
          font-weight: 500;
        }

        .social-media {
          display: flex;
          justify-content: center;
        }

        .social-icon {
          height: 46px;
          width: 46px;
          display: flex;
          justify-content: center;
          align-items: center;
          margin: 0 0.45rem;
          color: #091a13;
          border-radius: 50%;
          border: 1px solid #cbd5e1;
          text-decoration: none;
          font-size: 1rem;
          transition: 0.3s;
        }

        .social-icon:hover {
          color: #10b981;
          border-color: #10b981;
          background: #ecfdf5;
          transform: translateY(-2px);
        }

        .auth-btn {
          width: 150px;
          background-color: #10b981;
          border: none;
          outline: none;
          height: 49px;
          border-radius: 49px;
          color: #040907;
          text-transform: uppercase;
          font-weight: 700;
          margin: 10px 0;
          cursor: pointer;
          transition: 0.5s;
          font-family: inherit;
          letter-spacing: 0.04em;
        }

        .auth-btn:hover {
          background-color: #059669;
          color: #ffffff;
          box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
          transform: translateY(-1px);
        }

        .panels-container {
          position: absolute;
          height: 100%;
          width: 100%;
          top: 0;
          left: 0;
          display: grid;
          grid-template-columns: repeat(2, 1fr);
        }

        .auth-container:before {
          content: "";
          position: absolute;
          height: 2000px;
          width: 2000px;
          top: -10%;
          right: 48%;
          transform: translateY(-50%);
          background-image: linear-gradient(-45deg, #091a13 0%, #064e3b 50%, #040907 100%);
          transition: 1.8s ease-in-out;
          border-radius: 50%;
          z-index: 6;
          box-shadow: inset 0 0 100px rgba(16, 185, 129, 0.15);
        }

        .panel {
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          justify-content: space-around;
          text-align: center;
          z-index: 6;
        }

        .left-panel {
          pointer-events: all;
          padding: 3rem 17% 2rem 12%;
        }

        .right-panel {
          pointer-events: none;
          padding: 3rem 12% 2rem 17%;
        }

        .panel .content {
          color: #ffffff;
          transition: transform 0.9s ease-in-out;
          transition-delay: 0.6s;
        }

        .panel h3 {
          font-weight: 800;
          line-height: 1.2;
          font-size: 1.85rem;
          color: #ffffff;
        }

        .panel p {
          font-size: 0.95rem;
          padding: 0.7rem 0;
          color: #a7f3d0;
          line-height: 1.5;
        }

        .auth-btn.transparent {
          margin: 0;
          background: transparent;
          border: 2px solid #10b981;
          width: 140px;
          height: 44px;
          font-weight: 700;
          font-size: 0.85rem;
          color: #ffffff;
        }

        .auth-btn.transparent:hover {
          background: #10b981;
          color: #040907;
        }

        .right-panel .image,
        .right-panel .content {
          transform: translateX(800px);
        }

        .image {
          width: 100%;
          transition: transform 1.1s ease-in-out;
          transition-delay: 0.4s;
          max-width: 440px;
        }

        /* ANIMATION STATES */
        .auth-container.sign-up-mode:before {
          transform: translate(100%, -50%);
          right: 52%;
        }

        .auth-container.sign-up-mode .left-panel .image,
        .auth-container.sign-up-mode .left-panel .content {
          transform: translateX(-800px);
        }

        .auth-container.sign-up-mode .signin-signup {
          left: 25%;
        }

        .auth-container.sign-up-mode .auth-form.sign-up-form {
          opacity: 1;
          z-index: 2;
        }

        .auth-container.sign-up-mode .auth-form.sign-in-form {
          opacity: 0;
          z-index: 1;
        }

        .auth-container.sign-up-mode .right-panel .image,
        .auth-container.sign-up-mode .right-panel .content {
          transform: translateX(0%);
        }

        .auth-container.sign-up-mode .left-panel {
          pointer-events: none;
        }

        .auth-container.sign-up-mode .right-panel {
          pointer-events: all;
        }

        @media (max-width: 870px) {
          .auth-container {
            min-height: 800px;
            height: 100vh;
          }
          .signin-signup {
            width: 100%;
            top: 95%;
            transform: translate(-50%, -100%);
            transition: 1s 0.8s ease-in-out;
            left: 50%;
          }
          .panels-container {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 2fr 1fr;
          }
          .panel {
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            padding: 2.5rem 8%;
            grid-column: 1 / 2;
          }
          .right-panel {
            grid-row: 3 / 4;
          }
          .left-panel {
            grid-row: 1 / 2;
          }
          .image {
            width: 200px;
            transition: transform 0.9s ease-in-out;
            transition-delay: 0.6s;
          }
          .panel .content {
            padding-right: 15%;
            transition: transform 0.9s ease-in-out;
            transition-delay: 0.8s;
          }
          .panel h3 {
            font-size: 1.2rem;
          }
          .panel p {
            font-size: 0.7rem;
            padding: 0.5rem 0;
          }
          .auth-btn.transparent {
            width: 110px;
            height: 35px;
            font-size: 0.7rem;
          }
          .auth-container:before {
            width: 1500px;
            height: 1500px;
            transform: translateX(-50%);
            left: 30%;
            bottom: 68%;
            right: initial;
            top: initial;
            transition: 2s ease-in-out;
          }
          .auth-container.sign-up-mode:before {
            transform: translate(-50%, 100%);
            bottom: 32%;
            right: initial;
          }
          .auth-container.sign-up-mode .left-panel .image,
          .auth-container.sign-up-mode .left-panel .content {
            transform: translateY(-300px);
          }
          .auth-container.sign-up-mode .right-panel .image,
          .auth-container.sign-up-mode .right-panel .content {
            transform: translateY(0px);
          }
          .right-panel .image,
          .right-panel .content {
            transform: translateY(300px);
          }
          .auth-container.sign-up-mode .signin-signup {
            top: 5%;
            transform: translate(-50%, 0);
            left: 50%;
          }
        }

        @media (max-width: 570px) {
          .auth-form {
            padding: 0 1.5rem;
          }
          .image {
            display: none;
          }
          .panel .content {
            padding: 0.5rem 1rem;
          }
          .auth-container:before {
            bottom: 72%;
            left: 50%;
          }
          .auth-container.sign-up-mode:before {
            bottom: 28%;
            left: 50%;
          }
        }
      `}</style>

      <div className={`auth-container ${isSignUp ? "sign-up-mode" : ""}`}>
        <div className="forms-container">
          <div className="signin-signup">
            {/* SIGN IN FORM */}
            <form action="/login" method="POST" onSubmit={onSubmit} className="auth-form sign-in-form">
              <h2 className="auth-title">Sign In</h2>
              <div className="input-field">
                <i>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                </i>
                <input type="email" placeholder="Email Address" required />
              </div>
              <div className="input-field">
                <i>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                </i>
                <input type="password" placeholder="Password" required />
              </div>
              <button type="submit" className="auth-btn">
                Login
              </button>
              <p className="social-text">Or sign in with social platforms</p>
              <div className="social-media">
                <a href="#social" className="social-icon" aria-label="Sign in with Google">
                  G
                </a>
                <a href="#social" className="social-icon" aria-label="Sign in with GitHub">
                  Gh
                </a>
                <a href="#social" className="social-icon" aria-label="Sign in with LinkedIn">
                  In
                </a>
              </div>
            </form>

            {/* SIGN UP FORM */}
            <form action="/register" method="POST" onSubmit={onSubmit} className="auth-form sign-up-form">
              <h2 className="auth-title">Sign Up</h2>
              <div className="input-field">
                <i>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                </i>
                <input type="text" placeholder="Full Name" required />
              </div>
              <div className="input-field">
                <i>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                  </svg>
                </i>
                <input type="email" placeholder="Email Address" required />
              </div>
              <div className="input-field">
                <i>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                </i>
                <input type="password" placeholder="Create Password" required />
              </div>
              <button type="submit" className="auth-btn">
                Sign Up
              </button>
              <p className="social-text">Or sign up with social platforms</p>
              <div className="social-media">
                <a href="#social" className="social-icon" aria-label="Sign up with Google">
                  G
                </a>
                <a href="#social" className="social-icon" aria-label="Sign up with GitHub">
                  Gh
                </a>
                <a href="#social" className="social-icon" aria-label="Sign up with LinkedIn">
                  In
                </a>
              </div>
            </form>
          </div>
        </div>

        {/* PANELS */}
        <div className="panels-container">
          <div className="panel left-panel">
            <div className="content">
              <h3>New to FurShield?</h3>
              <p>
                Join our clinical pet care and adoption platform today. Create your account to start managing companion health records and adoptions.
              </p>
              <button
                type="button"
                className="auth-btn transparent"
                onClick={() => setIsSignUp(true)}
              >
                Sign Up
              </button>
            </div>
            <img
              src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80"
              className="image"
              alt="FurShield companion pet"
              style={{ borderRadius: "24px", objectFit: "cover", maxHeight: "300px" }}
            />
          </div>

          <div className="panel right-panel">
            <div className="content">
              <h3>One of us?</h3>
              <p>
                Welcome back to FurShield. Access your pets, verified health passports, records, and shelter communications.
              </p>
              <button
                type="button"
                className="auth-btn transparent"
                onClick={() => setIsSignUp(false)}
              >
                Sign In
              </button>
            </div>
            <img
              src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80"
              className="image"
              alt="FurShield companion cat"
              style={{ borderRadius: "24px", objectFit: "cover", maxHeight: "300px" }}
            />
          </div>
        </div>
      </div>
    </div>
  );
}
