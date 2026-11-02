import { Router } from 'express';
import * as userController from '../controllers/user.controller';
import { requireAuth, requireRole, requireSelfOrAdmin } from '../middleware/auth';
import { upload } from '../middleware/upload';

export const userRoutes = Router();

// Semua butuh login. List/create khusus Admin; Owner akses datanya sendiri.
userRoutes.get('/', requireAuth, requireRole('Admin'), userController.list);
userRoutes.get('/:username', requireAuth, requireSelfOrAdmin('username'), userController.detail);
userRoutes.post('/', requireAuth, requireRole('Admin'), upload.any(), userController.create);
userRoutes.put('/:username', requireAuth, requireSelfOrAdmin('username'), upload.any(), userController.update);
userRoutes.delete('/:username', requireAuth, requireRole('Admin'), userController.remove);
