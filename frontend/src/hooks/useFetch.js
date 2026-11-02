import { useCallback, useEffect, useRef, useState } from 'react';

// fetcher: () => Promise<data>. key: nilai yang bila berubah memicu reload
// (mis. [user.username]).
export function useFetch(fetcher, key = []) {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const fetcherRef = useRef(fetcher);
  fetcherRef.current = fetcher;

  const reload = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const result = await fetcherRef.current();
      setData(result);
    } catch (err) {
      setError(err);
    } finally {
      setLoading(false);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, key);

  useEffect(() => {
    reload();
  }, [reload]);

  return { data, loading, error, reload };
}

// Pagination client-side generik (search + entries + halaman).
export function useClientTable(rows, { initialPerPage = 10 } = {}) {
  const [query, setQuery] = useState('');
  const [perPage, setPerPage] = useState(initialPerPage);
  const [page, setPage] = useState(1);

  const safeRows = Array.isArray(rows) ? rows : [];
  const q = query.trim().toLowerCase();
  const filtered = q
    ? safeRows.filter((row) =>
        Object.values(row ?? {})
          .join(' ')
          .toLowerCase()
          .includes(q)
      )
    : safeRows;

  const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
  const current = Math.min(page, totalPages);
  const pageRows = filtered.slice((current - 1) * perPage, current * perPage);

  useEffect(() => {
    setPage(1);
  }, [query, perPage]);

  return {
    query, setQuery,
    perPage, setPerPage,
    page: current, setPage,
    total: filtered.length,
    totalPages,
    pageRows,
  };
}
