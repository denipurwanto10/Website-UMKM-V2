import { useState } from 'react';
import { Link, NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import ThemeToggle from './ThemeToggle';

export function PublicNavbar() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const [open, setOpen] = useState(false);
  const close = () => setOpen(false);

  return (
    <nav className="navbar navbar-expand-lg navbar-dark sticky-top public-nav">
      <div className="container">
        <Link className="navbar-brand fw-bold d-flex align-items-center" to="/" onClick={close}>
          <img src="/logo.png" alt="UMKM" height={38} className="me-2 rounded" />
          <span>UMKM <span className="d-none d-sm-inline">Kab. Bandung</span><span className="d-sm-none">KBB</span></span>
        </Link>
        <button
          className="navbar-toggler"
          type="button"
          aria-label="Menu navigasi"
          aria-expanded={open}
          onClick={() => setOpen((o) => !o)}
        >
          <span className="navbar-toggler-icon" />
        </button>
        <div className={`collapse navbar-collapse ${open ? 'show' : ''}`}>
          <ul className="navbar-nav ms-auto align-items-lg-center gap-lg-1">
            <li className="nav-item"><NavLink className="nav-link" to="/" end onClick={close}>Home</NavLink></li>
            <li className="nav-item"><NavLink className="nav-link" to="/semua" onClick={close}>Semua UMKM</NavLink></li>
            <li className="nav-item"><NavLink className="nav-link" to="/peta" onClick={close}>Peta</NavLink></li>
            <li className="nav-item ms-lg-1">
              <ThemeToggle />
            </li>
            {user ? (
              <>
                <li className="nav-item">
                  <NavLink className="nav-link" to="/dashboard" onClick={close}>Dashboard</NavLink>
                </li>
                <li className="nav-item ms-lg-2">
                  <button
                    className="btn btn-sm btn-outline-light w-100"
                    onClick={() => { close(); logout(); navigate('/'); }}
                  >
                    Keluar
                  </button>
                </li>
              </>
            ) : (
              <li className="nav-item ms-lg-2">
                <Link className="btn btn-sm btn-success w-100 px-3" to="/login" onClick={close}>Masuk</Link>
              </li>
            )}
          </ul>
        </div>
      </div>
    </nav>
  );
}

export function PublicFooter() {
  return (
    <footer className="mt-5 public-footer">
      <div className="container py-5 text-white">
        <div className="row g-3 align-items-center">
          <div className="col-md-7">
            <div className="d-flex align-items-center gap-2">
              <img src="/logo.png" alt="logo" height={34} className="rounded" />
              <strong>Portal UMKM Kabupaten Bandung</strong>
            </div>
            <small className="d-block mt-2 opacity-75">
              Dinas Perdagangan dan Perindustrian Kabupaten Bandung — mendukung
              pertumbuhan ekonomi lokal yang mandiri dan berdaya saing.
            </small>
          </div>
          <div className="col-md-5">
            <div className="d-flex flex-wrap gap-2 justify-content-md-end">
              <Link className="btn btn-sm btn-outline-light" to="/semua">Katalog UMKM</Link>
              <Link className="btn btn-sm btn-outline-light" to="/peta">Peta</Link>
              <Link className="btn btn-sm btn-success" to="/login">Masuk</Link>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}

export function Loading({ text = 'Memuat...' }) {
  return (
    <div className="text-center py-5" role="status" aria-live="polite">
      <div className="spinner-border text-success" />
      <div className="mt-2 text-muted">{text}</div>
    </div>
  );
}

export function ErrorBox({ error, onRetry }) {
  return (
    <div className="alert alert-danger d-flex justify-content-between align-items-center">
      <span>{String(error?.message || error || 'Gagal memuat data.')}</span>
      {onRetry && (
        <button className="btn btn-sm btn-outline-danger" onClick={onRetry}>
          Coba lagi
        </button>
      )}
    </div>
  );
}

export function Pagination({ page, totalPages, onChange }) {
  if (totalPages <= 1) return null;
  const pages = [];
  for (let i = 1; i <= totalPages; i += 1) {
    if (i === 1 || i === totalPages || Math.abs(i - page) <= 2) pages.push(i);
    else if (pages[pages.length - 1] !== '…') pages.push('…');
  }
  return (
    <nav>
      <ul className="pagination pagination-sm mb-0">
        <li className={`page-item ${page === 1 ? 'disabled' : ''}`}>
          <button className="page-link" onClick={() => onChange(page - 1)}>Prev</button>
        </li>
        {pages.map((p, idx) =>
          p === '…' ? (
            <li key={`e${idx}`} className="page-item disabled"><span className="page-link">…</span></li>
          ) : (
            <li key={p} className={`page-item ${p === page ? 'active' : ''}`}>
              <button className="page-link" onClick={() => onChange(p)}>{p}</button>
            </li>
          )
        )}
        <li className={`page-item ${page === totalPages ? 'disabled' : ''}`}>
          <button className="page-link" onClick={() => onChange(page + 1)}>Next</button>
        </li>
      </ul>
    </nav>
  );
}
