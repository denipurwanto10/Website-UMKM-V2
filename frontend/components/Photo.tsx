import { useEffect, useRef, useState } from 'react';
import { cn } from '../lib/utils';

/** Gambar dengan shimmer saat memuat, fade-in setelah siap, dan fallback bila gagal. */
export function Photo({
  src,
  alt,
  className,
  fallback,
  loading = 'lazy',
}: {
  src?: string;
  alt: string;
  className?: string;
  fallback?: React.ReactNode;
  loading?: 'lazy' | 'eager';
}) {
  const [loaded, setLoaded] = useState(false);
  const [failed, setFailed] = useState(false);
  const ref = useRef<HTMLImageElement>(null);

  useEffect(() => {
    if (ref.current?.complete && ref.current.naturalWidth > 0) setLoaded(true);
  }, [src]);

  if (!src || failed) {
    return <div className={cn('grid place-items-center bg-muted text-muted-foreground', className)}>{fallback}</div>;
  }
  return (
    <div className={cn('relative overflow-hidden bg-muted', !loaded && 'skeleton', className)}>
      <img
        ref={ref}
        src={src}
        alt={alt}
        loading={loading}
        onLoad={() => setLoaded(true)}
        onError={() => setFailed(true)}
        className={cn(
          'h-full w-full object-cover transition-[opacity,transform] duration-[900ms] ease-smooth group-hover:scale-[1.04]',
          loaded ? 'opacity-100' : 'opacity-0',
        )}
      />
    </div>
  );
}
