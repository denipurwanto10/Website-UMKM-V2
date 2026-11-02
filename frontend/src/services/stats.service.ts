import api from './api';
import type { Stats } from '../types';
import type { Envelope } from './api';

export async function getStats() {
  const res = await api.get<Envelope<Stats>>('/stats');
  return res.data.data;
}
