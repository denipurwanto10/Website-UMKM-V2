import { z } from 'zod';

// Port validasi Promosi::store (6 field required)
export const createPromosiSchema = z.object({
  username: z.string().min(1, 'Username wajib diisi'),
  fasilitasi_promosi: z.string().min(1, 'Fasilitasi promosi wajib diisi'),
  hambatan_memasarkan_produk: z.string().min(1, 'Hambatan memasarkan produk wajib diisi'),
  bantuan_dibutuhkan: z.string().min(1, 'Bantuan dibutuhkan wajib diisi'),
  berminat_bazar_ramadhan: z.enum(['Ya', 'Tidak']),
  berminat_pelatihan_online: z.enum(['Ya', 'Tidak']),
});

export const updatePromosiSchema = createPromosiSchema.omit({ username: true }).partial();
