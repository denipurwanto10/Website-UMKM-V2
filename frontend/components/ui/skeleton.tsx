import * as React from 'react';
import { cn } from '../../lib/utils';

/** Placeholder loading dengan shimmer — tabel/kartu tidak "melompat" saat data masuk. */
export function Skeleton({ className, ...props }: React.HTMLAttributes<HTMLDivElement>) {
  return <div className={cn('skeleton rounded-lg', className)} {...props} />;
}
