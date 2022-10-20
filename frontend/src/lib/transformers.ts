export const transformPost = ({
	id,
	attributes: {
		author: {
			data: author,
		},
		image: {
			data: image,
		},
		...post
	},
}) => {
	return {
		id,
		author: author ? {
			id: author.id,
			...author.attributes,
		} : null,
		image: image ? {
			id: image.id,
			...image.attributes,
		} : null,
		...post
	};
};
