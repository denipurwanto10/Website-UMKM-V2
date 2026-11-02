import { createContext, useContext, useEffect, useState } from 'react';

const ThemeContext = createContext({
  theme: 'light',
  dark: false,
  toggle: () => {},
  setTheme: () => {},
});

function initialTheme() {
  try {
    return window.localStorage.getItem('umkm_theme') === 'dark' ? 'dark' : 'light';
  } catch {
    return 'light';
  }
}

export function ThemeProvider({ children }) {
  // Default SELALU light mode; 'dark' hanya bila pengguna pernah memilihnya.
  const [theme, setThemeState] = useState(initialTheme);

  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme);
    // Bootstrap 5.3 ikut adaptif (card, table, form, alert, pagination, ...).
    document.documentElement.setAttribute('data-bs-theme', theme);
    try {
      window.localStorage.setItem('umkm_theme', theme);
    } catch {
      /* penyimpanan tidak tersedia — tema tetap berlaku sesi ini */
    }
  }, [theme]);

  const setTheme = (t) => setThemeState(t === 'dark' ? 'dark' : 'light');
  const toggle = () => setThemeState((t) => (t === 'dark' ? 'light' : 'dark'));

  return (
    <ThemeContext.Provider value={{ theme, dark: theme === 'dark', toggle, setTheme }}>
      {children}
    </ThemeContext.Provider>
  );
}

export function useTheme() {
  return useContext(ThemeContext);
}
