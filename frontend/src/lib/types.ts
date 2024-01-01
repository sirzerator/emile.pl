type Locale = 'en' | 'fr';

interface Localized {
	locale: Locale;
}

export interface About extends Localized {
	job: string;
	situation: string;
	aka: string;
	email: string;
	telephone: string;
	education: string;
	availability: 'unavailable' | 'short_term' | 'medium_term' | 'long_term' | 'available';
	bio: string;
}

export interface Contact extends Localized {
	content: string;
}

export interface Category extends Localized {
	title: string;
}

export interface Genre extends Localized {
	title: string;
}

export interface Post extends Localized {
	id: number;
	title: string;
	slug: string;
	intro: string;
	content: string;
	published_at: string | null;
	featured_image_url: string | null;
	category: Category | null;
}

export interface Reading extends Localized {
	id: number;
	title: string;
	author: string;
	genre: Genre;
	finished_at: string | null;
	cover_image_url: string | null;
}

export interface User {
	id: number;
	username: string;
	email: string;
	provider: string;
	confirmed: boolean;
	blocked: boolean;
	role: Role;
	createdAt: string;
	updatedAt: string;
	posts: Post[];
	fullname: string;
}

export interface Role {
	id: number;
	name: string;
	description: string;
	type: string;
}

export interface Author extends Omit<Omit<User, 'posts'>, 'role'> {
	role: Role['id'];
}
