import type { ReactNode } from 'react';
import { Link } from 'react-router-dom';

/** Garis kontur — gema lanskap dataran tinggi Bandung selatan. */
function Contours({ className }: { className?: string }) {
  return (
    <svg viewBox="0 0 400 620" preserveAspectRatio="xMidYMid slice" fill="none" stroke="currentColor" strokeWidth="1" className={className} aria-hidden>
      {[0, 1, 2, 3, 4, 5, 6, 7, 8].map((i) => (
        <path
          key={i}
          d={`M-20 ${90 + i * 62} C 60 ${40 + i * 62}, 120 ${150 + i * 62}, 200 ${100 + i * 62} S 340 ${30 + i * 62}, 420 ${90 + i * 62}`}
        />
      ))}
    </svg>
  );
}

export function AuthShell({
  title,
  description,
  children,
  footer,
}: {
  title: string;
  description: string;
  children: ReactNode;
  footer: ReactNode;
}) {
  return (
    <div className="mx-auto grid max-w-4xl overflow-hidden rounded-3xl border border-border bg-card shadow-[0_28px_70px_-32px_rgb(0_0_0/0.28)] lg:grid-cols-[0.85fr_1.15fr]">
      <aside className="relative hidden flex-col justify-between overflow-hidden bg-[linear-gradient(155deg,#0d8a65_0%,#065a42_50%,#04271d_100%)] p-10 text-white lg:flex">
        <Contours className="absolute inset-0 h-full w-full opacity-[0.16]" />
        <Link to="/" className="relative flex items-center gap-3">
          <span className="grid h-10 w-10 place-items-center rounded-xl bg-white">
            <img src="/logo.png" alt="" className="h-7 w-7 object-contain" />
          </span>
          <span className="text-sm font-semibold">UMKM Kab. Bandung</span>
        </Link>
        <div className="relative">
          <p className="font-display text-[1.7rem] leading-snug">
            Kelola data usaha dan ajukan kebutuhan promosi.
          </p>
          <p className="mt-4 text-sm text-white/70">
            Dinas Perdagangan dan Perindustrian Kabupaten Bandung
          </p>
        </div>
      </aside>
      <div className="p-6 sm:p-10">
        <div className="auth-rise">
          <h1 className="text-3xl font-medium tracking-tight">{title}</h1>
          <p className="mt-1.5 text-sm text-muted-foreground">{description}</p>
          <div className="mt-8">{children}</div>
        </div>
        <div className="auth-rise mt-6 text-center text-sm text-muted-foreground" style={{ animationDelay: '260ms' }}>
          {footer}
        </div>
      </div>
    </div>
  );
}
