import { useEffect, useRef, useState } from 'react';
import type { CSSProperties, ElementType, ReactNode } from 'react';
import { useLocation } from 'react-router-dom';
import { cn } from './utils';

/** True saat elemen pertama kali masuk viewport (sekali saja). */
export function useInView<T extends Element = HTMLDivElement>(rootMargin = '0px 0px -6% 0px') {
  const ref = useRef<T | null>(null);
  const [inView, setInView] = useState(false);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;
    if (typeof IntersectionObserver === 'undefined') {
      setInView(true);
      return;
    }
    const io = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setInView(true);
          io.disconnect();
        }
      },
      { rootMargin, threshold: 0.06 },
    );
    io.observe(el);
    return () => io.disconnect();
  }, [rootMargin]);

  return { ref, inView };
}

/** Membungkus elemen yang naik halus saat terlihat. `delay` (ms) untuk berurutan. */
export function Reveal({
  children,
  delay = 0,
  as,
  className,
  style,
}: {
  children: ReactNode;
  delay?: number;
  as?: ElementType;
  className?: string;
  style?: CSSProperties;
}) {
  const { ref, inView } = useInView<HTMLElement>();
  const Tag = (as ?? 'div') as ElementType;
  return (
    <Tag
      ref={ref}
      data-in={inView}
      className={cn('reveal', className)}
      style={{ ...style, ['--d' as string]: `${delay}ms` }}
    >
      {children}
    </Tag>
  );
}

/** Angka naik dengan easing, mulai saat terlihat; animasi lanjut dari nilai sebelumnya. */
export function CountUp({
  value,
  duration = 1500,
  className,
}: {
  value: number;
  duration?: number;
  className?: string;
}) {
  const { ref, inView } = useInView<HTMLSpanElement>();
  const [n, setN] = useState(0);
  const from = useRef(0);

  useEffect(() => {
    if (!inView) return;
    const target = Number.isFinite(value) ? value : 0;
    const reduce = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
    if (reduce || target === from.current) {
      from.current = target;
      setN(target);
      return;
    }
    const start = from.current;
    const t0 = performance.now();
    let raf = 0;
    const tick = (t: number) => {
      const p = Math.min(1, (t - t0) / duration);
      const eased = p === 1 ? 1 : 1 - Math.pow(2, -10 * p); // easeOutExpo
      const cur = Math.round(start + (target - start) * eased);
      from.current = cur;
      setN(cur);
      if (p < 1) raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(raf);
  }, [inView, value, duration]);

  return (
    <span ref={ref} className={cn('tabular-nums', className)}>
      {n.toLocaleString('id-ID')}
    </span>
  );
}

/**
 * Transisi antarhalaman + scroll ke atas / ke anchor (#kategori, #umkm).
 * Di-key per pathname, jadi query string (?status=) tidak memicu animasi ulang.
 */
export function PageTransition({ children }: { children: ReactNode }) {
  const { pathname, hash } = useLocation();

  useEffect(() => {
    if (hash) {
      const id = decodeURIComponent(hash.slice(1));
      const t = window.setTimeout(
        () => document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' }),
        140,
      );
      return () => window.clearTimeout(t);
    }
    window.scrollTo({ top: 0, behavior: 'instant' as ScrollBehavior });
  }, [pathname, hash]);

  return (
    <div key={pathname} className="page-enter">
      {children}
    </div>
  );
}
