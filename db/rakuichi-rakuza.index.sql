CREATE INDEX idx_fleamarkets_01 ON `fleamarkets`(`event_date`, `deleted_at`);
CREATE INDEX idx_fleamarket_abouts_01 ON `fleamarket_abouts`(`fleamarket_id`, `about_id`);
CREATE INDEX idx_fleamarket_entry_styles_01 ON `fleamarket_entry_styles`(`fleamarket_id`, `entry_style_id`);
CREATE INDEX idx_locations_01 ON `locations`(`location_id`, `prefecture_id`);
