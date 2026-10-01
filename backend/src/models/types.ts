// Shared types — cerminkan kolom MySQL existing (tanpa mengubah DB).
export type Usertype = 'Admin' | 'Owner';
export type UmkmStatus = 'menunggu' | 'disetujui' | 'ditolak';
export type YaTidak = 'Ya' | 'Tidak';

export interface UserRow {
  username: string;
  fullname: string;
  usertype: Usertype;
  nomor_hp: string;
  email: string;
  password: string;
  photo: string;
}

/** User yang dikembalikan ke klien — TANPA password. */
export type PublicUser = Omit<UserRow, 'password'>;

export interface JwtPayload {
  username: string;
  usertype: Usertype;
  iat?: number;
  exp?: number;
}

export interface UmkmRow {
  id: number;
  username: string;
  nama_usaha: string;
  nama_merek_produk: string;
  kategori_produk: string;
  jenis_usaha: string;
  pendapatan: string;
  jalan: string;
  desa_kelurahan: string;
  kecamatan: string;
  nib: string | null;
  pirt: string | null;
  bpom: string | null;
  halal: string | null;
  haki: string | null;
  lainnya: string | null;
  online: string | null;
  offline: string | null;
  agen_reseller: string | null;
  deskripsi_produk: string;
  photo: string;
  status: UmkmStatus;
  catatan: string;
  whatsapp: string | null;
  blibli: string | null;
  lazada: string | null;
  shopee: string | null;
  tokopedia: string | null;
  facebook: string | null;
  instagram: string | null;
  tiktok: string | null;
  twitter: string | null;
  fullname?: string;
}

export interface PromosiRow {
  id: number;
  username: string;
  fasilitasi_promosi: string;
  hambatan_memasarkan_produk: string;
  bantuan_dibutuhkan: string;
  berminat_bazar_ramadhan: YaTidak;
  berminat_pelatihan_online: YaTidak;
  fullname?: string;
}

export interface ApiEnvelope<T> {
  success: boolean;
  message: string;
  data: T;
}
