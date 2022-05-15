const timeout = function (ms: number) {
	return new Promise((resolve, reject) => {
		setTimeout(() => {
			resolve(true);
		}, ms);
	});
};
export default timeout;
