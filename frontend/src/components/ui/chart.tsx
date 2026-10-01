import * as React from 'react';
import { cn } from '../../lib/utils';

// Pola chart ala shadcn-admin (dashboard): container responsif + tooltip gelap netral.
// Hitam-putih: tidak ada warna aksen, semua grayscale via currentColor / token.

export function ChartContainer({
  className,
  children,
}: {
  className?: string;
  children: React.ReactNode;
}) {
  return <div className={cn('h-64 w-full sm:h-72', className)}>{children}</div>;
}

export function ChartTooltipContent({
  active,
  payload,
  label,
}: {
  active?: boolean;
  payload?: { name?: string; value?: number | string; payload?: Record<string, unknown> }[];
  label?: string | number;
}) {
  if (!active || !payload || payload.length === 0) return null;
  return (
    <div className="rounded-md border border-border bg-popover px-3 py-2 text-xs text-popover-foreground">
      {label !== undefined && label !== '' && <p className="mb-1 font-semibold">{label}</p>}
      {payload.map((p, i) => (
        <p key={i} className="flex items-center justify-between gap-4">
          <span className="text-muted-foreground">{p.name}</span>
          <span className="font-medium">{p.value}</span>
        </p>
      ))}
    </div>
  );
}
