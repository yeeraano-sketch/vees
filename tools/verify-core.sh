#!/usr/bin/env bash

set -e

echo "================ Framework ================"
find src/Framework -type f | sort

echo
echo "================ SharedKernel ================"
find src/SharedKernel -type f | sort

echo
echo "================ Illuminate ================"
grep -R "Illuminate\\\\" src | grep -v Infrastructure/Providers || true

echo
echo "================ EventBus Legacy ================"
grep -R "LaravelEventBus" src || true

echo
echo "================ Legacy Contracts ================"
grep -R "SharedKernel\\\\Contracts\\\\Command" src || true
grep -R "SharedKernel\\\\Contracts\\\\Query" src || true
grep -R "SharedKernel\\\\Contracts\\\\CommandBus" src || true
grep -R "SharedKernel\\\\Contracts\\\\QueryBus" src || true
grep -R "SharedKernel\\\\Contracts\\\\Repository" src || true

echo
echo "================ Registrars ================"
find src -path "*/Infrastructure/Providers/*Registrar.php" | sort

echo
echo "================ Service Providers ================"
find src -path "*/Infrastructure/Providers/*ServiceProvider.php" | sort

echo
echo "================ ModulesRegistry ================"
cat src/Framework/Modules/ModulesRegistry.php
