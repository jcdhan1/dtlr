module.exports = {
	preset: 'ts-jest',
	testEnvironment: 'node',
	testMatch: ['<rootDir>/tests/js/**/*.test.ts'],
	transform: {
		'^.+\\.tsx?$': ['ts-jest', { tsconfig: { esModuleInterop: true } }],
	},
};
