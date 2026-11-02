import * as React from 'react';
import { Eye, EyeOff } from 'lucide-react';
import { Input } from './ui/input';

export const PasswordInput = React.forwardRef<HTMLInputElement, React.InputHTMLAttributes<HTMLInputElement>>(
  (props, ref) => {
    const [show, setShow] = React.useState(false);
    return (
      <div className="relative">
        <Input ref={ref} {...props} type={show ? 'text' : 'password'} className="pe-11" />
        <button
          type="button"
          onClick={() => setShow((v) => !v)}
          aria-label={show ? 'Sembunyikan password' : 'Tampilkan password'}
          className="absolute inset-y-0 end-0 grid w-11 place-items-center text-muted-foreground transition-colors hover:text-foreground"
        >
          <span key={String(show)} className="icon-swap">
            {show ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
          </span>
        </button>
      </div>
    );
  },
);
PasswordInput.displayName = 'PasswordInput';
