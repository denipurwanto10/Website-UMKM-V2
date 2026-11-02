import { Toaster } from 'sonner';
import { useTheme } from '../hooks/useTheme';

export function AppToaster() {
  const { theme } = useTheme();
  return (
    <Toaster
      theme={theme}
      position="top-center"
      richColors
      toastOptions={{ classNames: { toast: '!rounded-2xl !font-sans !shadow-lg' } }}
    />
  );
}
