import { Moon, Sun } from 'lucide-react';
import { Button } from './ui/button';
import { useTheme } from '../hooks/useTheme';

export function ThemeToggle() {
  const { theme, toggle } = useTheme();
  const label = theme === 'dark' ? 'Mode terang' : 'Mode gelap';
  return (
    <Button variant="ghost" size="icon" onClick={toggle} aria-label={label} title={label}>
      {/* key memaksa remount → ikon baru berputar masuk */}
      <span key={theme} className="icon-swap grid place-items-center">
        {theme === 'dark' ? <Sun className="h-4 w-4" /> : <Moon className="h-4 w-4" />}
      </span>
    </Button>
  );
}
