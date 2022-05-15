type Locale = 'en' | 'fr';

interface Localized {
	locale: Locale;
}

export interface About extends Localized {
	siteName: string;
	slogan: string;
	situation: string;
	aka: string;
	email: string;
	telephone: string;
	education: string;
	availability: 'unavailable' | 'short_term' | 'medium_term' | 'long_term' | 'available';
	bio: string;
	created_at: string;
	updated_at: string;
}

export interface Post extends Localized {
	id: number;
	title: string;
	description: string;
	content: string;
	author: Author;
	created_at: string;
	updated_at: string;
}

export interface User {
	id: number;
	username: string;
	email: string;
	provider: string;
	confirmed: boolean;
	blocked: boolean;
	role: Role;
	created_at: string;
	updated_at: string;
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
