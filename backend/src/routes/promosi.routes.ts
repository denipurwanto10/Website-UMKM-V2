import { Router } from 'express';
import * as promosiController from '../controllers/promosi.controller';
import { requireAuth, requireRole } from '../middleware/auth';

export const promosiRoutes = Router();

promosiRoutes.get('/', promosiController.list);
promosiRoutes.get('/user/:username', promosiController.byUsername);
promosiRoutes.get('/:id', promosiController.detail);
promosiRoutes.post('/', requireAuth, promosiController.create);
promosiRoutes.put('/:id', requireAuth, promosiController.update);
promosiRoutes.delete('/:id', requireAuth, requireRole('Admin', 'Owner'), promosiController.remove);
