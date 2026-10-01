import * as React from 'react';
import { cn } from '../../lib/utils';

/** Placeholder loading — tabel/kartu tidak "melompat" saat data masuk. */
export function Skeleton({ className, ...props }: React.HTMLAttributes<HTMLDivElement>) {
  return <div className={cn('animate-pulse rounded-md bg-muted', className)} {...props} />;
}