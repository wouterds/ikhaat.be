# ikhaat.be

![ci](https://github.com/wouterds/wouterdeschuyter.be/workflows/ci/badge.svg)
![tag)](https://img.shields.io/github/tag/wouterds/ikhaat.be.svg)
![repo size](https://img.shields.io/github/repo-size/wouterds/ikhaat.be.svg)

Source code of [ikhaat.be](https://ikhaat.be), formerly [kabouterwesley.be](https://kabouterwesley.be). I mainly use this as a basic test project for CI/CD.

## Setup

```bash
cp .env.example .env
make qemu-arm-static
```

### Running

```shell
docker-compose -f ./.docker/docker-compose-dev.yml up
```
