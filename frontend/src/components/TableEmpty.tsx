import type { ReactNode } from 'react';
import { Inbox } from 'lucide-react';
import { Skeleton } from './ui/skeleton';

/** empty = belum ada data; error = gagal memuat — tampil rapi, bukan teks polos. */
export function TableEmpty({
  colSpan,
  state,
  message,
  action,
}: {
  colSpan: number;
  state: 'loading' | 'empty' | 'error';
  message?: string;
  action?: ReactNode;
}) {
  return (
    <TableRowish colSpan={colSpan}>
      {state === 'loading' ? (
        <div className="flex flex-col gap-3 py-4">
          {[0, 1, 2].map((i) => (
            <Skeleton key={i} className="h-9 w-full" />
          ))}
        </div>
      ) : (
        <div className="flex flex-col items-center gap-2 py-8 text-center">
          <span className="flex h-11 w-11 items-center justify-center rounded-full bg-muted text-muted-foreground">
            {state === 'empty' ? <Inbox className="h-5 w-5" /> : <AlertGlyph />}
          </span>
          <p className="text-sm text-muted-foreground">{message ?? 'Belum ada data.'}</p>
          {action}
        </div>
      )}
    </TableRowish>
  );
}

function AlertGlyph() {
  return (
    <svg viewBox="0 0 24 24" className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round">
      <path d="M12 9v4M12 17h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
    </svg>
  );
}

// Helper kecil supaya markup konsisten dengan <TableRow><TableCell colSpan>.
import { TableCell, TableRow } from './ui/table';
function TableRowish({ colSpan, children }: { colSpan: number; children: ReactNode }) {
  return (
    <TableRow>
      <TableCell colSpan={colSpan} className="py-2">
        {children}
      </TableCell>
    </TableRow>
  );
}