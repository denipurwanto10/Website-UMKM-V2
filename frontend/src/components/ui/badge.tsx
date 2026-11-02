import * as React from 'react';
import { cva, type VariantProps } from 'class-variance-authority';
import { cn } from '../../lib/utils';

const badgeVariants = cva(
  'inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-[11.5px] font-medium leading-5 transition-colors focus:outline-none',
  {
    variants: {
      variant: {
        default: 'border-transparent bg-primary text-primary-foreground',
        secondary: 'border-transparent bg-muted text-muted-foreground',
        destructive:
          'border-transparent bg-danger-soft text-destructive before:size-1.5 before:rounded-full before:bg-current',
        outline: 'border-border text-foreground',
        success:
          'border-transparent bg-success-soft text-success before:size-1.5 before:rounded-full before:bg-current',
        warning:
          'border-transparent bg-warning-soft text-warning before:size-1.5 before:rounded-full before:bg-current',
      },
    },
    defaultVariants: { variant: 'default' },
  },
);

export interface BadgeProps extends React.HTMLAttributes<HTMLDivElement>, VariantProps<typeof badgeVariants> {}

function Badge({ className, variant, ...props }: BadgeProps) {
  return <div className={cn(badgeVariants({ variant }), className)} {...props} />;
}

export { Badge, badgeVariants };
